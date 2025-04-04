<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\PlantImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plants = Plant::with('images')->orderBy('name')->paginate(10);
        return view('admin.plants.index', compact('plants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.plants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'common_names' => 'nullable|string',
            'family' => 'nullable|string|max:100',
            'native_range' => 'nullable|string',
            'age' => 'nullable|string|max:50',
            'current_height' => 'nullable|string|max:100',
            'expected_height' => 'nullable|string|max:100',
            'leaf_type' => 'nullable|string',
            'bloom_time' => 'nullable|string|max:255',
            'flower_color' => 'nullable|string|max:100',
            'fruit' => 'nullable|string',
            'light' => 'nullable|string|max:255',
            'soil' => 'nullable|string|max:255',
            'hardiness' => 'nullable|string|max:100',
            'other_comments' => 'nullable|string',
            'images.*' => 'nullable|image|max:5120', // 5MB max per image
        ]);

        $plant = Plant::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $imageOrder = 0;
            foreach ($request->file('images') as $image) {
                $path = $image->store('plants', 'public');
                $plant->images()->create([
                    'image_path' => Storage::url($path),
                    'image_order' => $imageOrder++
                ]);
            }
        }

        return redirect()->route('admin.plants.index')
            ->with('success', 'Plant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Use the Eloquent model to find the plant and eager load relationships
        $plant = Plant::findOrFail($id);
        // Load the relationships separately to avoid using with() on a query builder
        $plant->load(['images', 'maintenanceLogs.images']);
        $maintenanceLogs = $plant->maintenanceLogs()->with('images')->paginate(5);
        
        return view('admin.plants.show', compact('plant', 'maintenanceLogs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plant = Plant::with('images')->findOrFail($id);
        return view('admin.plants.edit', compact('plant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $plant = Plant::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'common_names' => 'nullable|string',
            'family' => 'nullable|string|max:100',
            'native_range' => 'nullable|string',
            'age' => 'nullable|string|max:50',
            'current_height' => 'nullable|string|max:100',
            'expected_height' => 'nullable|string|max:100',
            'leaf_type' => 'nullable|string',
            'bloom_time' => 'nullable|string|max:255',
            'flower_color' => 'nullable|string|max:100',
            'fruit' => 'nullable|string',
            'light' => 'nullable|string|max:255',
            'soil' => 'nullable|string|max:255',
            'hardiness' => 'nullable|string|max:100',
            'other_comments' => 'nullable|string',
            'images.*' => 'nullable|image|max:5120', // 5MB max per image
        ]);

        $plant->update($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $imageOrder = $plant->images()->max('image_order') + 1;
            foreach ($request->file('images') as $image) {
                $path = $image->store('plants', 'public');
                $plant->images()->create([
                    'image_path' => Storage::url($path),
                    'image_order' => $imageOrder++
                ]);
            }
        }

        return redirect()->route('admin.plants.index')
            ->with('success', 'Plant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plant = Plant::findOrFail($id);
        
        // Soft deleting for production would be better, but let's clean up images
        foreach ($plant->images as $image) {
            $path = str_replace('/storage/', 'public/', $image->image_path);
            Storage::delete($path);
        }
        
        $plant->delete();

        return redirect()->route('admin.plants.index')
            ->with('success', 'Plant deleted successfully.');
    }
    
    /**
     * Remove a specific image from a plant
     */
    public function deleteImage(string $plantId, string $imageId)
    {
        // First, verify that the plant exists
        $plant = Plant::findOrFail($plantId);
        
        // Then find the image that belongs to this plant
        $image = PlantImage::where('plant_id', $plantId)
                           ->where('id', $imageId)
                           ->firstOrFail();
        
        // Delete the physical file
        $path = str_replace('/storage/', 'public/', $image->image_path);
        Storage::delete($path);
        
        // Delete the image record
        $image->delete();
        
        return back()->with('success', 'Image deleted successfully.');
    }
    
    /**
     * Reorder the images of a plant
     */
    public function reorderImages(Request $request, string $id)
    {
        $plant = Plant::findOrFail($id);
        
        $request->validate([
            'order' => 'required|array',
            'order.*' => [
                'integer',
                Rule::exists('plant_images', 'id')->where(function ($query) use ($plant) {
                    $query->where('plant_id', $plant->id);
                }),
            ],
        ]);
        
        foreach ($request->order as $index => $imageId) {
            PlantImage::where('id', $imageId)->update(['image_order' => $index]);
        }
        
        return response()->json(['success' => true]);
    }
}
