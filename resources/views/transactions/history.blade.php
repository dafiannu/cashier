<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900/30 p-4 text-green-800 dark:text-green-200 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    {{-- <form method="GET" class="mb-4 flex flex-wrap gap-2">
                        <input 
                            type="date" 
                            name="start_date" 
                            value="{{ request('start_date') }}"
                            class="border rounded px-3 py-2 text-sm"
                        >

                        <input 
                            type="date" 
                            name="end_date" 
                            value="{{ request('end_date') }}"
                            class="border rounded px-3 py-2 text-sm"
                        >

                        <button class="bg-slate-900 text-white px-4 py-2 rounded text-sm">
                            Filter
                        </button>

                        <a href="{{ route('transactions.history') }}" class="px-4 py-2 border rounded text-sm">
                            Reset
                        </a>
                    </form> --}}
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600">ID</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600">{{ __('Tanggal') }}</th>
                                <th class="ppx-6 py-3 text-left font-semibold text-gray-600">{{ __('Kasir') }}</th>
                                <th class="px-6 py-3 text-right font-semibold text-gray-600">{{ __('Total') }}</th>
                                <th class="px-6 py-3 text-right font-semibold text-gray-600">{{ __('Bayar') }}</th>
                                <th class="px-6 py-3 text-right font-semibold text-gray-600">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($transactions as $tx)
                                <tr>
                                    <td class="px-6 py-4 text-gray-900">{{ $tx->id }}</td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $tx->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $tx->user->name }}</td>
                                    <td class="px-6 py-4 text-gray-600 text-right">Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-gray-600 text-right">Rp {{ number_format($tx->pay_total, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-gray-600 text-right">
                                        <a class="rounded-md border border-blue-300 px-3 py-1.5 text-blue-600" href="{{ route('transactions.show', $tx) }}">{{ __('Detail') }}</a>
                                        <a class="rounded-md border border-green-300 px-3 py-1.5 text-green-600" href="{{ route('transactions.receipt', $tx->id) }}">Struk</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('Belum ada transaksi.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- <div class="mt-4"> {{ $transactions->links() }} </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
