<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sales Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-4">
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Categories</p>
                    <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $categoryCount }}</p>
                </div>
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Items</p>
                    <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $itemCount }}</p>
                </div>
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Transactions</p>
                    <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $transactionCount }}</p>
                </div>
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Total Sales</p>
                    <p class="mt-3 text-3xl font-semibold text-gray-900">${{ number_format($totalSales, 2) }}</p>
                </div>
            </div>

            <div class="mt-6 rounded-xl bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                <p class="mt-2 text-sm text-gray-600">Manage your master data, build a cart, and print a receipt after checkout.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('categories.index') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Manage Categories</a>
                    <a href="{{ route('items.index') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Manage Items</a>
                    <a href="{{ route('cart.index') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white">Open Cashier Cart</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
