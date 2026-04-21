<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $items = Item::with('category')->orderBy('name')->get();
        $cart = session('cart', []);
        $total = $this->cartTotal($cart);

        return view('cart.index', compact('items', 'cart', 'total'));
    }

    public function add(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'qty' => ['nullable', 'integer', 'min:1'],
        ]);

        $item = Item::findOrFail($id);
        $qtyToAdd = (int) ($validated['qty'] ?? 1);
        $cart = session('cart', []);
        $existingQty = (int) ($cart[$item->id]['qty'] ?? 0);
        $newQty = $existingQty + $qtyToAdd;

        if ($newQty > $item->stock) {
            return redirect()->route('cart.index')->with('error', 'Requested quantity exceeds current stock.');
        }

        $cart[$item->id] = [
            'name' => $item->name,
            'price' => (float) $item->price,
            'qty' => $newQty,
            'subtotal' => (float) $item->price * $newQty,
        ];

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Item added to cart.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session('cart', []);

        if (! isset($cart[$id])) {
            return redirect()->route('cart.index')->with('error', 'Item not found in cart.');
        }

        $item = Item::findOrFail($id);
        $qty = (int) $validated['qty'];

        if ($qty > $item->stock) {
            return redirect()->route('cart.index')->with('error', 'Requested quantity exceeds current stock.');
        }

        $cart[$id]['qty'] = $qty;
        $cart[$id]['subtotal'] = (float) $cart[$id]['price'] * $qty;

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    public function remove(int $id): RedirectResponse
    {
        $cart = session('cart', []);

        unset($cart[$id]);

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function clear(): RedirectResponse
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully.');
    }

    public function checkout(Request $request): RedirectResponse
    {
        $cart = session('cart', []);
        $total = $this->cartTotal($cart);

        if (empty($cart) || $total <= 0) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty. Add items before checkout.');
        }

        $validated = $request->validate([
            'pay_total' => ['required', 'numeric', 'min:'.$total],
        ]);

        $transaction = DB::transaction(function () use ($cart, $validated) {
            $itemIds = array_keys($cart);
            $items = Item::whereIn('id', $itemIds)->lockForUpdate()->get()->keyBy('id');

            $total = 0;
            $details = [];

            foreach ($cart as $itemId => $cartItem) {
                $item = $items->get((int) $itemId);

                if (! $item) {
                    abort(404, 'One of the cart items no longer exists.');
                }

                $qty = (int) $cartItem['qty'];

                if ($qty > $item->stock) {
                    throw ValidationException::withMessages([
                        'cart' => "Stock for {$item->name} is no longer sufficient.",
                    ]);
                }

                $subtotal = (float) $item->price * $qty;
                $total += $subtotal;

                $details[] = [
                    'item' => $item,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                ];
            }

            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'date' => now(),
                'total' => $total,
                'pay_total' => $validated['pay_total'],
            ]);

            foreach ($details as $detail) {
                $transaction->transactionDetails()->create([
                    'item_id' => $detail['item']->id,
                    'qty' => $detail['qty'],
                    'subtotal' => $detail['subtotal'],
                ]);

                $detail['item']->decrement('stock', $detail['qty']);
            }

            return $transaction;
        });

        session()->forget('cart');

        return redirect()
            ->route('transactions.receipt', $transaction->id)
            ->with('success', 'Checkout completed successfully.');
    }

    private function cartTotal(array $cart): float
    {
        return (float) collect($cart)->sum('subtotal');
    }
}
