<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductDetailController extends Controller
{
    public function index(Request $request)
    {
        $productId = $request->query('id'); // get ?id= from URL
        $product = Product::find($productId);

        if (!$product) {
            abort(404); // product not found
        }

        return view('frontend.product-detail', compact('product'));
    }
}
