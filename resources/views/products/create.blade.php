<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Product') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block">Product Name:</label>
                <input type="text" name="title" class="border p-2 w-full" required>
            </div>

            <div class="mb-4">
                <label class="block">Price:</label>
                <input type="number" name="price" class="border p-2 w-full" required>
            </div>

            <div class="mb-4">
                <label class="block">Product Image:</label>
                <input type="file" name="image" class="border p-2 w-full">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</x-app-layout>
