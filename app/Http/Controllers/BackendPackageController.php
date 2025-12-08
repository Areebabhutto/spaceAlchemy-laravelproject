<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Product;
use App\Models\Service;

class BackendPackageController extends Controller
{
    /**
     * Display a listing of packages
     */
    public function index() {
        $packages = Package::with('product', 'services')->get();
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new package
     */
    public function create() {
        $products = Product::all();
        $services = Service::all();
        return view('admin.packages.create', compact('products', 'services'));
    }

    /**
     * Store a newly created package
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'product_id' => 'required|exists:products,id',
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
        ]);

        $package = Package::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'product_id' => $request->product_id,
        ]);

        // Attach services to package
        $package->services()->attach($request->services);

        return redirect()->route('packages.index')->with('success', 'Package created successfully!');
    }

    /**
     * Show the form for editing a package
     */
    public function edit(Package $package) {
        $products = Product::all();
        $services = Service::all();
        $selectedServices = $package->services->pluck('id')->toArray();
        return view('admin.packages.edit', compact('package', 'products', 'services', 'selectedServices'));
    }

    /**
     * Update the specified package
     */
    public function update(Request $request, Package $package) {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'product_id' => 'required|exists:products,id',
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
        ]);

        $package->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'product_id' => $request->product_id,
        ]);

        // Sync services (this will replace existing associations)
        $package->services()->sync($request->services);

        return redirect()->route('packages.index')->with('success', 'Package updated successfully!');
    }

    /**
     * Remove a package
     */
    public function destroy(Package $package) {
        $package->delete();
        return redirect()->route('packages.index')->with('success', 'Package deleted successfully!');
    }

    /**
     * Search packages by name and description
     */
    public function search(Request $request) {
        $query = $request->get('query', '');
        
        if (strlen($query) < 1) {
            return response()->json([]);
        }
        
        $packages = Package::with('product', 'services')
                          ->where('name', 'like', '%' . $query . '%')
                          ->orWhere('description', 'like', '%' . $query . '%')
                          ->limit(10)
                          ->get();
        
        return response()->json($packages);
    }
}
