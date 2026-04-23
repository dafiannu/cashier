<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function receipt(int $id): View
    {
        $transaction = Transaction::with(['user', 'transactionDetails.item'])->findOrFail($id);

        return view('transactions.receipt', compact('transaction'));
    }

    public function history(): View
    {
        $transactions = Transaction::with('user')
            ->when(request('start_date'), function ($q) {
                $q->whereDate('date', '>=', request('start_date'));
            })
            ->when(request('end_date'), function ($q) {
                $q->whereDate('date', '<=', request('end_date'));
            })
            ->orderBy('date', 'desc')
            // ->paginate(10)
            // ->withQueryString();
            ->get();

        return view('transactions.history', compact('transactions'));
    }

    public function show(int $id): View
    {
        $transaction = Transaction::with(['user', 'transactionDetails.item'])->findOrFail($id);

        return view('transactions.show', compact('transaction'));
    }
}
