<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Cashier Cart</h2>
    </x-slot>

    @php($rupiah = fn ($amount) => 'Rp '.number_format((float) $amount, 0, ',', '.'))

    <div class="py-10">
        <div class="mx-auto grid max-w-7xl gap-6 lg:grid-cols-[1.1fr_0.9fr] sm:px-6 lg:px-8">
            <div class="space-y-4">
                @include('partials.flash')

                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Available Items</h3>
                            <p class="text-sm text-gray-500">Add products to the session-based cart.</p>
                        </div>
                        <a href="{{ route('items.create') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700">New Item</a>
                    </div>

                    <div class="space-y-3">
                        @forelse ($items as $item)
                            <div class="flex flex-col gap-3 rounded-xl border border-gray-200 p-4 md:flex-row md:items-center md:justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $item->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->category->name }} | {{ $rupiah($item->price) }}</p>
                                    <p class="text-sm 
                                        {{ $item->stock == 0 
                                            ? 'font-semibold text-red-600' 
                                            : ($item->stock <= 10 ? 'font-semibold text-amber-600' : 'text-gray-500') }}">
                                        Stock: {{ $item->stock }}
                                        @if($item->stock == 0)
                                            <span class="ml-1">(out of stock)</span>
                                        @elseif($item->stock <= 10)
                                            <span class="ml-1">(low stock)</span>
                                        @endif
                                    </p>
                                </div>
                                <form action="{{ route('cart.add', $item->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <input
                                        type="number"
                                        name="qty"
                                        min="1"
                                        max="{{ $item->stock }}"
                                        value="1"
                                        class="w-20 rounded-lg border border-gray-300 px-3 py-2 text-sm"
                                        {{ $item->stock < 1 ? 'disabled' : '' }}
                                    >
                                    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white" {{ $item->stock < 1 ? 'disabled' : '' }}>
                                        Add
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="rounded-xl border border-dashed border-gray-300 px-4 py-10 text-center text-gray-500">No items available yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Current Cart</h3>
                            <p class="text-sm text-gray-500">Stored in the current session.</p>
                        </div>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-red-300 px-3 py-2 text-sm font-medium text-red-600" onclick="return confirm('Clear cart?')">Clear Cart</button>
                        </form>
                    </div>

                    <div class="space-y-4">
                        @forelse ($cart as $itemId => $cartItem)
                            <div class="rounded-xl border border-gray-200 p-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $cartItem['name'] }}</p>
                                        <p class="text-sm text-gray-500">{{ $rupiah($cartItem['price']) }} each</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-700">Subtotal: {{ $rupiah($cartItem['subtotal']) }}</p>
                                    </div>
                                    <form action="{{ route('cart.remove', $itemId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-600">Remove</button>
                                    </form>
                                </div>

                                <form action="{{ route('cart.update', $itemId) }}" method="POST" class="mt-4 flex items-center gap-2">
                                    @csrf
                                    <input
                                        type="number"
                                        name="qty"
                                        min="1"
                                        value="{{ $cartItem['qty'] }}"
                                        class="w-24 rounded-lg border border-gray-300 px-3 py-2 text-sm"
                                        required
                                    >
                                    <button type="submit" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700">Update Qty</button>
                                </form>
                            </div>
                        @empty
                            <p class="rounded-xl border border-dashed border-gray-300 px-4 py-10 text-center text-gray-500">Cart is empty.</p>
                        @endforelse
                    </div>

                    <div class="mt-6 rounded-xl bg-slate-50 p-4">
                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <span>Total</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $rupiah($total) }}</span>
                        </div>
                    </div>

                    <form action="{{ route('cart.checkout') }}" method="POST" class="mt-6 space-y-4">
                        @csrf
                        <div>
                            <label for="pay_total" class="mb-2 block text-sm font-medium text-gray-700">Pay Total</label>
                            <input
                                id="pay_total"
                                name="pay_total"
                                type="number"
                                min="{{ $total > 0 ? $total : 0 }}"
                                step="0.01"
                                value="{{ old('pay_total', $total > 0 ? (int) ceil($total) : '') }}"
                                {{-- value="{{ old('pay_total', '') }}" --}}
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5"
                                required
                            >
                        </div>
                        <button type="submit" class="w-full rounded-lg bg-emerald-600 px-4 py-3 text-sm font-semibold text-white" {{ empty($cart) ? 'disabled' : '' }}>
                            Checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
