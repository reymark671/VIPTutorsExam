<table class="w-full border-collapse border border-gray-200">
    <thead>
        <tr class="bg-gray-100">
            <th class="border p-2">Image</th>
            <th class="border p-2">Title</th>
            <th class="border p-2">Price</th>
            <th class="border p-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            <tr>
                <td class="border p-2">
                    @if ($product->image)
                        <img src="{{ Storage::disk('ftp')->url($product->image) }}" alt="Product Image" class="w-16 h-16">
                    @else
                        No Image
                    @endif
                </td>
                <td class="border p-2">{{ $product->title }}</td>
                <td class="border p-2">${{ $product->price }}</td>
                <td class="border p-2">
                    <a href="{{ route('products.edit', $product) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
