<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class PackageApiController extends Controller
{
    /**
     * Display a listing of all packages
     */
    public function index()
    {
        try {
            $packages = Package::with('product', 'services')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Packages retrieved successfully',
                'data' => $packages,
                'total' => $packages->count()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving packages',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a specific package
     */
    public function show($id)
    {
        try {
            $package = Package::with('product', 'services')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Package retrieved successfully',
                'data' => $package
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving package',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new package
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'product_id' => 'required|exists:products,id',
                'service_ids' => 'array',
                'service_ids.*' => 'exists:services,id'
            ]);

            $package = Package::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'product_id' => $validated['product_id']
            ]);

            // Attach services if provided
            if (isset($validated['service_ids'])) {
                $package->services()->sync($validated['service_ids']);
            }

            $package->load('product', 'services');

            return response()->json([
                'success' => true,
                'message' => 'Package created successfully',
                'data' => $package
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating package',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a package
     */
    public function update(Request $request, $id)
    {
        try {
            $package = Package::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'sometimes|required|numeric|min:0',
                'product_id' => 'sometimes|required|exists:products,id',
                'service_ids' => 'array',
                'service_ids.*' => 'exists:services,id'
            ]);

            $package->update($validated);

            // Update services if provided
            if (isset($validated['service_ids'])) {
                $package->services()->sync($validated['service_ids']);
            }

            $package->load('product', 'services');

            return response()->json([
                'success' => true,
                'message' => 'Package updated successfully',
                'data' => $package
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating package',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a package
     */
    public function destroy($id)
    {
        try {
            $package = Package::findOrFail($id);
            
            // Detach all services before deleting
            $package->services()->detach();
            
            $package->delete();

            return response()->json([
                'success' => true,
                'message' => 'Package deleted successfully'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting package',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get packages by product
     */
    public function getByProduct($productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $packages = Package::where('product_id', $productId)->with('services')->get();

            return response()->json([
                'success' => true,
                'message' => 'Packages retrieved successfully',
                'data' => $packages,
                'product' => $product,
                'total' => $packages->count()
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving packages',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search packages
     */
    public function search(Request $request)
    {
        try {
            $query = $request->input('q', '');
            
            $packages = Package::where('name', 'LIKE', "%$query%")
                ->orWhere('description', 'LIKE', "%$query%")
                ->with('product', 'services')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Search completed successfully',
                'data' => $packages,
                'total' => $packages->count(),
                'query' => $query
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching packages',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
