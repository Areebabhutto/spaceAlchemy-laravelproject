<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        $services = Service::all();
        return view('frontend.index', compact('services'));
    }
}
