<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminDestinationController extends Controller
{
    /**
     * Display a listing of all destinations with their assigned editors.
     */
    public function index()
    {
        $destinations = Destination::with('assignedEditor')->get();
        
        return view('admin.destinations.index', compact('destinations'));
    }

    /**
     * Show the form for editing the specified destination.
     */
    public function edit(Destination $destination)
    {
        $editors = User::where('role', 'editor')->get();
        
        return view('admin.destinations.edit', compact('destination', 'editors'));
    }

    /**
     * Update the specified destination in storage.
     */
    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'coordinates' => 'nullable|string|max:255',
            'conservation_status' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'canton' => 'nullable|string|max:255',
            'parish' => 'nullable|string|max:255',
            'sector' => 'nullable|string|max:255',
            'reference_distance' => 'nullable|string|max:255',
            'climate_dry_season' => 'nullable|array',
            'climate_dry_season.name' => 'nullable|string|max:255',
            'climate_dry_season.months' => 'nullable|string|max:255',
            'climate_dry_season.temperature' => 'nullable|string|max:255',
            'climate_wet_season' => 'nullable|array',
            'climate_wet_season.name' => 'nullable|string|max:255',
            'climate_wet_season.months' => 'nullable|string|max:255',
            'climate_wet_season.temperature' => 'nullable|string|max:255',
            'access_from' => 'nullable|string|max:255',
            'access_route' => 'nullable|string|max:255',
            'access_transport' => 'nullable|string|max:255',
            'access_time' => 'nullable|string|max:255',
            'schedule_hours' => 'nullable|string|max:255',
            'entry_fee' => 'nullable|string|max:255',
            'season_availability' => 'nullable|string|max:255',
            'requirements' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_role' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'activities' => 'nullable|array',
            'activities.*.icon' => 'nullable|string|max:255',
            'activities.*.name' => 'nullable|string|max:255',
            'target_audience_type' => 'nullable|string|max:255',
            'target_audience_origin' => 'nullable|string|max:255',
            'target_audience_age' => 'nullable|string|max:255',
            'target_audience_transport' => 'nullable|string|max:255',
            'target_audience_stay' => 'nullable|string|max:255',
            'services' => 'nullable|array',
            'services.*.icon' => 'nullable|string|max:255',
            'services.*.name' => 'nullable|string|max:255',
            'services.*.available' => 'nullable|boolean',
            'average_price' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'payment_methods' => 'nullable|string|max:255',
            'mobile_coverage' => 'nullable|string|max:255',
            'tourism_criteria' => 'nullable|array',
            'tourism_criteria.access' => 'nullable|string|max:255',
            'tourism_criteria.access_status' => 'nullable|string|max:255',
            'tourism_criteria.security' => 'nullable|string|max:255',
            'tourism_criteria.personnel' => 'nullable|string|max:255',
            'tourism_criteria.languages' => 'nullable|string|max:255',
            'tourism_criteria.decoration' => 'nullable|string|max:255',
            'tourism_criteria.waste' => 'nullable|string|max:255',
            'main_description' => 'nullable|string',
            'secondary_description' => 'nullable|string',
            'strengths_benefits' => 'nullable|string',
            'environmental_challenges' => 'nullable|array',
            'environmental_challenges.*.icon' => 'nullable|string|max:255',
            'environmental_challenges.*.title' => 'nullable|string|max:255',
            'environmental_challenges.*.description' => 'nullable|string',
            'gallery_images' => 'nullable|array|max:8',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'remove_gallery_images' => 'nullable|array',
            'remove_gallery_images.*' => 'nullable|integer',
        ]);

        // Clean up empty array items
        if (isset($validated['activities'])) {
            $validated['activities'] = array_filter($validated['activities'], function($activity) {
                return !empty($activity['name']);
            });
            $validated['activities'] = array_values($validated['activities']); // Reindex
        }

        if (isset($validated['services'])) {
            $validated['services'] = array_filter($validated['services'], function($service) {
                return !empty($service['name']);
            });
            $validated['services'] = array_values($validated['services']); // Reindex
        }

        // Save tourism_criteria as associative array directly

        if (isset($validated['environmental_challenges'])) {
            $validated['environmental_challenges'] = array_filter($validated['environmental_challenges'], function($challenge) {
                return !empty($challenge['title']);
            });
            $validated['environmental_challenges'] = array_values($validated['environmental_challenges']); // Reindex
        }

        // Handle gallery image uploads
        // Get reordered images from explicit order input
        $order = $request->input('gallery_order');
        $currentImages = $order ? explode(',', $order) : ($destination->gallery_images ?? []);

        // Remove selected images
        if (!empty($validated['remove_gallery_images'])) {
            $indicesToRemove = array_map('intval', $validated['remove_gallery_images']);
            $currentImages = array_filter($currentImages, function($image, $index) use ($indicesToRemove) {
                return !in_array($index, $indicesToRemove);
            }, ARRAY_FILTER_USE_BOTH);
            $currentImages = array_values($currentImages); // Reindex
        }

        // Add new images
        if ($request->hasFile('gallery_images')) {
            foreach (request()->file('gallery_images') as $image) {
                if (count($currentImages) >= 8) break; // Max 8 images
                if ($image && $image->isValid()) {
                    $path = $image->store('destinations/gallery/' . $destination->id, 'public');
                    $currentImages[] = $path; // Store just the path, not the full URL
                }
            }
        }
        $validated['gallery_images'] = $currentImages;
        // Remove validation fields that aren't database columns
        unset($validated['remove_gallery_images'], $validated['existing_gallery_images']);

        // Update the destination with validated data
        $destination->update($validated);

        return redirect()->route('admin.destinations.edit', $destination)
            ->with('success', 'Destination updated successfully!');
    }
}
