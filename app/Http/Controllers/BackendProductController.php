<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class BackendProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index() {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }
   public function create() {
        return view('admin.products.create');
    }


    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            // Add validation for the image:
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);
        
        // 1. Get all non-token/method data
        $data = $request->except(['_token', '_method']);
        
        // 2. Handle the image upload
        if ($request->hasFile('image')) {
            // Store the file in the 'products' folder inside 'storage/app/public' 
            // and get the relative path. This uses the 'public' disk.
            $imagePath = $request->file('image')->store('products', 'public');
            
            // Add the image path to the data array
            $data['image'] = $imagePath;
        }

        // 3. Create the product with the updated data array
        $product = Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }





    public function edit(Product $product) {
        return view('admin.products.edit', compact('product'));
    }

public function update(Request $request, Product $product) {
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        // Add validation for the image (optional for update)
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $data = $request->all();

    // Handle image update
    if ($request->hasFile('image')) {
        // 1. Delete the old image if it exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // 2. Store the new file and get the path
        $imagePath = $request->file('image')->store('products', 'public');
        
        // 3. Update the data array with the new path
        $data['image'] = $imagePath;
    }

    // Update the product with the (potentially new) data
    $product->update($data);
    
    return redirect()->route('products.index')->with('success', 'Product updated successfully!');
}



    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * Search products by name and description
     */
    public function search(Request $request) {
        $query = $request->get('query', '');
        
        if (strlen($query) < 1) {
            return response()->json([]);
        }
        
        $products = Product::where('name', 'like', '%' . $query . '%')
                          ->orWhere('description', 'like', '%' . $query . '%')
                          ->limit(10)
                          ->get();
        
        return response()->json($products);
    }
}
