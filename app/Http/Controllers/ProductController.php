<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
{
    if (Auth::user()->is_admin) {
        // Admins see all products
        $products = Product::all();
    } else {
        // Regular users see only their own products
        $products = Product::where('user_id', Auth::id())->get();
    }

    return view('products.index', compact('products'));
}


    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            Storage::disk('ftp')->put('/products/' . $filename, file_get_contents($image));
            $imagePath = 'products/' . $filename;
        }

        $product = Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'user_id' => Auth::id(),
            'image' => $imagePath,
        ]);

        return redirect()->route('products')->with('success', 'Product added successfully!');
    }


    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $product->image; // Keep old image if no new one is uploaded

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            Storage::disk('ftp')->put('/products/' . $filename, file_get_contents($image));
            $imagePath = 'products/' . $filename;
        }

        $product->update([
            'title' => $request->title,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->route('products')->with('success', 'Product updated successfully!');
    }


    public function destroy(Product $product)
    {
        $user = Auth::user();

       
        if ($user->is_admin && $product->user) {
            return redirect()->route('products')->with('error', 'Admins cannot delete products assigned to a user!');
        }
        if (!$user->is_admin && $user->id !== $product->user_id) {
            return redirect()->route('products')->with('error', 'You can only delete your this products!');
        }

        $product->update(['del_flag' => 1]);

        return redirect()->route('products')->with('success', 'Product deleted successfully!');
    }
    public function show(Product $products)
    {
        return view('products.show', compact('products'));
    }
    public function addProductFromAPI(Request $request)
    {
        $provider = config('products.default_provider'); // Get from config
        $productService = ProductServiceFactory::make($provider);

        $response = $productService->addProduct([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),
            'category' => $request->input('category')
        ]);

        return response()->json($response->json());
    }

}

