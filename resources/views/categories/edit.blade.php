<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit Category</h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            @include('partials.flash')

            <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6 rounded-xl bg-white p-6 shadow-sm">
                @method('PUT')
                @include('categories.form', ['submitLabel' => 'Update Category'])
            </form>
        </div>
    </div>
</x-app-layout>
