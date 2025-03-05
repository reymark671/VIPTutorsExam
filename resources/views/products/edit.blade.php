<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block">Product Name:</label>
                <input type="text" name="title" class="border p-2 w-full" value="{{ $product->title }}" required>
            </div>

            <div class="mb-4">
                <label class="block">Price:</label>
                <input type="number" name="price" class="border p-2 w-full" value="{{ $product->price }}" required>
            </div>

            <div class="mb-4">
                <label class="block">Current Image:</label>
                @if ($product->image)
                    <img src="{{ Storage::disk('ftp')->url($product->image) }}" alt="Product Image" class="w-32 h-32">
                @endif
            </div>

            <div class="mb-4">
                <label class="block">New Product Image:</label>
                <input type="file" name="image" class="border p-2 w-full">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
</x-app-layout>
