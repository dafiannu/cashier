<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Create Item</h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            @include('partials.flash')

            <form action="{{ route('items.store') }}" method="POST" class="space-y-6 rounded-xl bg-white p-6 shadow-sm">
                @include('items.form', ['submitLabel' => 'Save Item'])
            </form>
        </div>
    </div>
</x-app-layout>
