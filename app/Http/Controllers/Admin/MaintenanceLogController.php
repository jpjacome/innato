<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceImage;
use App\Models\MaintenanceLog;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaintenanceLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $plantId = $request->query('plant_id');
        
        if ($plantId) {
            $plant = Plant::findOrFail($plantId);
            $maintenanceLogs = MaintenanceLog::where('plant_id', $plantId)
                ->with('images')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
                
            return view('admin.maintenance.index', compact('maintenanceLogs', 'plant'));
        }
        
        // If no plant_id is provided, show all maintenance logs
        $maintenanceLogs = MaintenanceLog::with(['plant', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.maintenance.index', compact('maintenanceLogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $plantId = $request->query('plant_id');
        $plants = Plant::orderBy('name')->get();
        
        if ($plantId) {
            $selectedPlant = Plant::findOrFail($plantId);
            return view('admin.maintenance.create', compact('plants', 'selectedPlant'));
        }
        
        return view('admin.maintenance.create', compact('plants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plant_id' => 'required|exists:plants,id',
            'last_watering' => 'nullable|date',
            'next_watering' => 'nullable|date',
            'last_fertilization' => 'nullable|date',
            'next_fertilization' => 'nullable|date',
            'last_pruning' => 'nullable|date',
            'next_pruning' => 'nullable|date',
            'pest_disease_inspection' => 'nullable|string',
            'images.*' => 'nullable|image|max:5120', // 5MB max per image
        ]);

        $maintenanceLog = MaintenanceLog::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('maintenance', 'public');
                $maintenanceLog->images()->create([
                    'image_path' => Storage::url($path)
                ]);
            }
        }

        return redirect()->route('admin.maintenance.index', ['plant_id' => $maintenanceLog->plant_id])
            ->with('success', 'Maintenance log created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $maintenanceLog = MaintenanceLog::with(['plant', 'images'])->findOrFail($id);
        return view('admin.maintenance.show', compact('maintenanceLog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maintenanceLog = MaintenanceLog::with('images')->findOrFail($id);
        $plants = Plant::orderBy('name')->get();
        return view('admin.maintenance.edit', compact('maintenanceLog', 'plants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $maintenanceLog = MaintenanceLog::findOrFail($id);

        $validated = $request->validate([
            'plant_id' => 'required|exists:plants,id',
            'last_watering' => 'nullable|date',
            'next_watering' => 'nullable|date',
            'last_fertilization' => 'nullable|date',
            'next_fertilization' => 'nullable|date',
            'last_pruning' => 'nullable|date',
            'next_pruning' => 'nullable|date',
            'pest_disease_inspection' => 'nullable|string',
            'images.*' => 'nullable|image|max:5120', // 5MB max per image
        ]);

        $maintenanceLog->update($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('maintenance', 'public');
                $maintenanceLog->images()->create([
                    'image_path' => Storage::url($path)
                ]);
            }
        }

        return redirect()->route('admin.maintenance.index', ['plant_id' => $maintenanceLog->plant_id])
            ->with('success', 'Maintenance log updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $maintenanceLog = MaintenanceLog::findOrFail($id);
        $plantId = $maintenanceLog->plant_id;
        
        // Delete all images associated with this maintenance log
        foreach ($maintenanceLog->images as $image) {
            $path = str_replace('/storage/', 'public/', $image->image_path);
            Storage::delete($path);
        }
        
        $maintenanceLog->delete();

        return redirect()->route('admin.maintenance.index', ['plant_id' => $plantId])
            ->with('success', 'Maintenance log deleted successfully.');
    }
    
    /**
     * Remove a specific image from a maintenance log
     */
    public function deleteImage(string $maintenanceId, string $imageId)
    {
        $image = MaintenanceImage::where('maintenance_id', $maintenanceId)->findOrFail($imageId);
        $path = str_replace('/storage/', 'public/', $image->image_path);
        Storage::delete($path);
        $image->delete();
        
        return back()->with('success', 'Image deleted successfully.');
    }
}
