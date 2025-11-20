<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;

class productsController extends Controller
{
    public function index()
    {
        // Get all products from database
        $products = Product::all();

        // Pass products to the view
        return view('frontend.products', compact('products'));
    }
}
