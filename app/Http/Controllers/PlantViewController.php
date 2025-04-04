<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\MaintenanceLog;
use Illuminate\Http\Request;

class PlantViewController extends Controller
{
    /**
     * Display the plant listing page
     */
    public function index()
    {
        $plants = Plant::with('images')->orderBy('name')->get();
        return view('public.plants.index', compact('plants'));
    }
    
    /**
     * Display a specific plant
     */
    public function show($id)
    {
        // First find the plant by ID
        $plant = Plant::findOrFail($id);
        // Then separately load the relationships
        $plant->load(['images', 'maintenanceLogs' => function($query) {
            $query->latest();
        }]);
        
        // Get the latest maintenance log separately
        $latestLog = $plant->maintenanceLogs->first();
        if ($latestLog) {
            $latestLog->load('images');
        }
        
        return view('public.plants.show', compact('plant'));
    }
    
    /**
     * Display the add plant form
     */
    public function create()
    {
        // This route will eventually be protected, but for now it's just a form
        return view('public.plants.create');
    }
    
    /**
     * Display the maintenance form
     */
    public function maintenance(Request $request)
    {
        $plantId = $request->query('plant_id');
        $plants = Plant::orderBy('name')->get();
        
        if ($plantId) {
            $selectedPlant = Plant::findOrFail($plantId);
            return view('public.plants.maintenance', compact('plants', 'selectedPlant'));
        }
        
        return view('public.plants.maintenance', compact('plants'));
    }
    
    /**
     * Backwards compatibility with the old public/plantas files
     * This will serve the legacy templates while we transition
     */
    public function legacyViewPlant(Request $request)
    {
        $id = $request->query('id', 1);
        return redirect()->route('public.plants.show', $id);
    }
    
    /**
     * Backwards compatibility with the old public/plantas add-plant.html
     */
    public function legacyAddPlant()
    {
        return redirect()->route('public.plants.create');
    }
    
    /**
     * Backwards compatibility with the old public/plantas maintenance-form.html
     */
    public function legacyMaintenance()
    {
        return redirect()->route('public.plants.maintenance');
    }
}
