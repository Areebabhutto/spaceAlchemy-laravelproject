<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class BackendServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            // Add validation for the icon (optional):
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);
        
        // 1. Get all non-token/method data
        $data = $request->except(['_token', '_method']);
        
        // 2. Handle the icon upload
        if ($request->hasFile('icon')) {
            // Store the file in the 'services' folder inside 'storage/app/public' 
            // and get the relative path. This uses the 'public' disk.
            $iconPath = $request->file('icon')->store('services', 'public');
            
            // Add the icon path to the data array
            $data['icon'] = $iconPath;
        }

        // 3. Create the service with the updated data array
        $service = Service::create($data);

        return redirect()->route('services.index')->with('success', 'Service added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service) {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            // Add validation for the icon (optional for update)
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        // Handle icon update
        if ($request->hasFile('icon')) {
            // 1. Delete the old icon if it exists
            if ($service->icon) {
                Storage::disk('public')->delete($service->icon);
            }

            // 2. Store the new file and get the path
            $iconPath = $request->file('icon')->store('services', 'public');
            
            // 3. Update the data array with the new path
            $data['icon'] = $iconPath;
        }

        // Update the service with the (potentially new) data
        $service->update($data);
        
        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service) {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully!');
    }

    /**
     * Search services by title and description
     */
    public function search(Request $request) {
        $query = $request->get('query', '');
        
        if (strlen($query) < 1) {
            return response()->json([]);
        }
        
        $services = Service::where('title', 'like', '%' . $query . '%')
                          ->orWhere('description', 'like', '%' . $query . '%')
                          ->limit(10)
                          ->get();
        
        return response()->json($services);
    }
}
