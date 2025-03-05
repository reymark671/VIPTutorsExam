<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Management') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 mb-4">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 text-white p-3 mb-4">{{ session('error') }}</div>
        @endif

        <div class="flex justify-between mb-4">
            <h2 class="text-2xl font-bold">Products</h2>
            <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Product</a>
        </div>

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Price</th>
                    <th class="border px-4 py-2">Assigned to User?</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="border px-4 py-2">{{ $product->id }}</td>
                        <td class="border px-4 py-2">{{ $product->title }}</td>
                        <td class="border px-4 py-2">${{ $product->price }}</td>
                        <td class="border px-4 py-2">
                            {{ $product->user ? 'Yes' : 'No' }}
                        </td>
                        <td class="border px-4 py-2">
                            <!-- Allow all users (admin and non-admin) to edit their own products -->
                            <a href="{{ route('products.show', $product) }}" class="bg-green-500 text-white px-3 py-1 rounded">View</a>
                            @if(Auth::user()->is_admin || Auth::id() === $product->user_id)
                                <a href="{{ route('products.edit', $product) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                            @endif

                            <!-- DELETE Button -->
                            @if(Auth::user()->is_admin)
                                @if(!$product->user) 
                                    <!-- Admin can delete only if the product is not assigned -->
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                @else
                                    <button class="bg-gray-400 text-white px-3 py-1 rounded cursor-not-allowed" disabled>Delete</button>
                                @endif
                            @elseif(Auth::id() === $product->user_id)
                                <!-- Non-admins can delete only their own products -->
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
