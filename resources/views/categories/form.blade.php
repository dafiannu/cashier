@csrf

<div>
    <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Category Name</label>
    <input
        id="name"
        name="name"
        type="text"
        value="{{ old('name', isset($category) ? $category->name : '') }}"
        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-slate-500 focus:outline-none focus:ring-0"
        required
    >
</div>

<div class="flex gap-3">
    <a href="{{ route('categories.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700">Cancel</a>
    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">{{ $submitLabel }}</button>
</div>
