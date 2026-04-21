<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Items</h2>
            <a href="{{ route('items.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Add Item</a>
        </div>
    </x-slot>

    @php($rupiah = fn ($amount) => 'Rp '.number_format((float) $amount, 0, ',', '.'))

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-4 sm:px-6 lg:px-8">
            @include('partials.flash')

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-600">Name</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-600">Category</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-600">Price</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-600">Stock</th>
                            <th class="px-6 py-3 text-right font-semibold text-gray-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($items as $item)
                            <tr>
                                <td class="px-6 py-4 text-gray-900">{{ $item->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $item->category->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $rupiah($item->price) }}</td>
                                <td class="px-6 py-4 {{ $item->stock <= 5 ? 'font-semibold text-amber-600' : 'text-gray-600' }}">{{ $item->stock }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('items.edit', $item) }}" class="rounded-md border border-gray-300 px-3 py-1.5 text-gray-700">Edit</a>
                                        <form action="{{ route('items.destroy', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md border border-red-300 px-3 py-1.5 text-red-600" onclick="return confirm('Delete this item?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">No items yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $items->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
