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
                    <p class="text-sm text-gray-500">Today's Transactions</p>
                    <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $transactionCount }}</p>
                </div>
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Today's Total Sales</p>
                    <p class="mt-3 text-3xl font-semibold text-gray-900">${{ number_format($totalSales, 2) }}</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
