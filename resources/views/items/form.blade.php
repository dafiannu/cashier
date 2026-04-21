@csrf

<div>
    <label for="category_id" class="mb-2 block text-sm font-medium text-gray-700">Category</label>
    <select
        id="category_id"
        name="category_id"
        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-slate-500 focus:outline-none focus:ring-0"
        required
    >
        <option value="">Select Category</option>
        @foreach ($categories as $categoryOption)
            <option value="{{ $categoryOption->id }}" @selected(old('category_id', isset($item) ? $item->category_id : '') == $categoryOption->id)>
                {{ $categoryOption->name }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Item Name</label>
    <input
        id="name"
        name="name"
        type="text"
        value="{{ old('name', isset($item) ? $item->name : '') }}"
        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-slate-500 focus:outline-none focus:ring-0"
        required
    >
</div>

<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label for="price" class="mb-2 block text-sm font-medium text-gray-700">Price</label>
        <input
            id="price"
            name="price"
            type="number"
            min="0"
            step="0.01"
            value="{{ old('price', isset($item) ? (float) $item->price : '') }}"
            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-slate-500 focus:outline-none focus:ring-0"
            required
        >
    </div>
    <div>
        <label for="stock" class="mb-2 block text-sm font-medium text-gray-700">Stock</label>
        <input
            id="stock"
            name="stock"
            type="number"
            min="0"
            step="1"
            value="{{ old('stock', isset($item) ? $item->stock : '') }}"
            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-slate-500 focus:outline-none focus:ring-0"
            required
        >
    </div>
</div>

<div class="flex gap-3">
    <a href="{{ route('items.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700">Cancel</a>
    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">{{ $submitLabel }}</button>
</div>
