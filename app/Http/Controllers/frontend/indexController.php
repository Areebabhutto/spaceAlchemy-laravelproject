<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Product;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        $services = Service::all();
        // Get best selling products - limit to 3
        $bestSellingProducts = Product::limit(3)->get();
        return view('frontend.index', compact('services', 'bestSellingProducts'));
    }
}
