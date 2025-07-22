<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditorDestinationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            // Admins can see all destinations
            $destinations = Destination::orderBy('title')->get();
        } else {
            // Editors can only see their assigned destination
            $destinations = Destination::where('id', $user->destination_id)->get();
        }
        
        return view('editor.destinations.index', compact('destinations'));
    }

    public function edit(Destination $destination)
    {
        $user = auth()->user();
        
        // Check if user can edit this destination
        if (!$user->canEditDestination($destination->id)) {
            abort(403, 'You are not authorized to edit this destination.');
        }
        
        return view('editor.destinations.edit', compact('destination'));
    }

    public function update(Request $request, Destination $destination)
    {
        $user = auth()->user();
        
        // Check if user can edit this destination
        if (!$user->canEditDestination($destination->id)) {
            abort(403, 'You are not authorized to edit this destination.');
        }

        // Enhanced debugging for target audience issue
        \Log::info('=== ENHANCED EDITOR DESTINATION UPDATE DEBUG ===');
        \Log::info('User ID: ' . $user->id);
        \Log::info('Destination ID: ' . $destination->id);
        \Log::info('Request method: ' . $request->method());
        \Log::info('Full URL: ' . $request->fullUrl());
        
        // Log all request data
        \Log::info('All request data received:', $request->all());
        
        // Specifically check target audience fields in request
        \Log::info('Target audience fields in request:');
        \Log::info('- target_audience_type: "' . $request->input('target_audience_type', 'NOT_PROVIDED') . '"');
        \Log::info('- target_audience_origin: "' . $request->input('target_audience_origin', 'NOT_PROVIDED') . '"');
        \Log::info('- target_audience_age: "' . $request->input('target_audience_age', 'NOT_PROVIDED') . '"');
        \Log::info('- target_audience_transport: "' . $request->input('target_audience_transport', 'NOT_PROVIDED') . '"');
        \Log::info('- target_audience_stay: "' . $request->input('target_audience_stay', 'NOT_PROVIDED') . '"');
        
        // Check if these fields exist at all in the request
        $targetAudienceExists = false;
        foreach (['target_audience_type', 'target_audience_origin', 'target_audience_age', 'target_audience_transport', 'target_audience_stay'] as $field) {
            if ($request->has($field)) {
                $targetAudienceExists = true;
                \Log::info("Field '{$field}' exists in request");
            } else {
                \Log::info("Field '{$field}' MISSING from request");
            }
        }
        \Log::info('Any target audience field exists: ' . ($targetAudienceExists ? 'YES' : 'NO'));
        
        // Current values before update
        \Log::info('Current destination values before update:');
        \Log::info('- target_audience_type: "' . $destination->target_audience_type . '"');
        \Log::info('- target_audience_origin: "' . $destination->target_audience_origin . '"');
        \Log::info('- target_audience_age: "' . $destination->target_audience_age . '"');
        \Log::info('- target_audience_transport: "' . $destination->target_audience_transport . '"');
        \Log::info('- target_audience_stay: "' . $destination->target_audience_stay . '"');

        $validated = $request->validate([
            // Basic Info
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'coordinates' => 'required|string|max:255',
            'conservation_status' => 'required|string|max:255',
            
            // Location
            'province' => 'required|string|max:255',
            'canton' => 'required|string|max:255',
            'parish' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
            'reference_distance' => 'required|string|max:255',
            
            // Climate
            'climate_dry_season' => 'required|array',
            'climate_dry_season.name' => 'required|string|max:255',
            'climate_dry_season.months' => 'required|string|max:255',
            'climate_dry_season.temperature' => 'required|string|max:255',
            'climate_wet_season' => 'required|array',
            'climate_wet_season.name' => 'required|string|max:255',
            'climate_wet_season.months' => 'required|string|max:255',
            'climate_wet_season.temperature' => 'required|string|max:255',
            
            // Access
            'access_from' => 'required|string|max:255',
            'access_route' => 'required|string|max:255',
            'access_transport' => 'required|string|max:255',
            'access_time' => 'required|string|max:255',
            
            // Schedule
            'schedule_hours' => 'required|string|max:255',
            'entry_fee' => 'required|string|max:255',
            'season_availability' => 'required|string|max:255',
            'requirements' => 'required|string|max:255',
            
            // Contact
            'contact_person' => 'required|string|max:255',
            'contact_role' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            
            // Activities
            'activities' => 'nullable|array',
            'activities.*.icon' => 'nullable|string|max:255',
            'activities.*.name' => 'nullable|string|max:255',
            
            // Target Audience
            'target_audience_type' => 'nullable|string|max:255',
            'target_audience_origin' => 'nullable|string|max:255',
            'target_audience_age' => 'nullable|string|max:255',
            'target_audience_transport' => 'nullable|string|max:255',
            'target_audience_stay' => 'nullable|string|max:255',
            
            // Services
            'services' => 'nullable|array',
            'services.*.icon' => 'nullable|string|max:255',
            'services.*.name' => 'nullable|string|max:255',
            'services.*.available' => 'nullable|boolean',
            
            // Pricing
            'average_price' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'payment_methods' => 'nullable|string|max:255',
            'mobile_coverage' => 'nullable|string|max:255',
            
            // Tourism Criteria
            'tourism_criteria' => 'nullable|array',
            'tourism_criteria.*.name' => 'nullable|string|max:255',
            'tourism_criteria.*.status' => 'nullable|in:positive,neutral,negative',
            
            // Descriptions
            'main_description' => 'nullable|string',
            'secondary_description' => 'nullable|string',
            'strengths_benefits' => 'nullable|string',
            
            // Environmental Challenges
            'environmental_challenges' => 'nullable|array',
            'environmental_challenges.*.icon' => 'nullable|string|max:255',
            'environmental_challenges.*.title' => 'nullable|string|max:255',
            'environmental_challenges.*.description' => 'nullable|string',
            
            // Gallery Images
            'gallery_images' => 'nullable|array|max:8',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'remove_gallery_images' => 'nullable|array',
            'remove_gallery_images.*' => 'nullable|integer',
        ]);

        // Log validated data
        \Log::info('Validation passed - validated data count: ' . count($validated));
        \Log::info('Target audience fields in validated data:');
        \Log::info('- target_audience_type: "' . ($validated['target_audience_type'] ?? 'NOT_IN_VALIDATED') . '"');
        \Log::info('- target_audience_origin: "' . ($validated['target_audience_origin'] ?? 'NOT_IN_VALIDATED') . '"');
        \Log::info('- target_audience_age: "' . ($validated['target_audience_age'] ?? 'NOT_IN_VALIDATED') . '"');
        \Log::info('- target_audience_transport: "' . ($validated['target_audience_transport'] ?? 'NOT_IN_VALIDATED') . '"');
        \Log::info('- target_audience_stay: "' . ($validated['target_audience_stay'] ?? 'NOT_IN_VALIDATED') . '"');

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

        if (isset($validated['tourism_criteria'])) {
            $validated['tourism_criteria'] = array_filter($validated['tourism_criteria'], function($criteria) {
                return !empty($criteria['name']);
            });
            $validated['tourism_criteria'] = array_values($validated['tourism_criteria']); // Reindex
        }

        if (isset($validated['environmental_challenges'])) {
            $validated['environmental_challenges'] = array_filter($validated['environmental_challenges'], function($challenge) {
                return !empty($challenge['title']);
            });
            $validated['environmental_challenges'] = array_values($validated['environmental_challenges']); // Reindex
        }

        // Handle gallery image uploads
        $currentImages = $destination->gallery_images ?? [];
        
        // Remove selected images
        if (!empty($validated['remove_gallery_images'])) {
            $indicesToRemove = array_map('intval', $validated['remove_gallery_images']);
            $currentImages = array_filter($currentImages, function($image, $index) use ($indicesToRemove) {
                return !in_array($index, $indicesToRemove);
            }, ARRAY_FILTER_USE_BOTH);
            $currentImages = array_values($currentImages); // Reindex
        }
        
        // Add new images
        if (request()->hasFile('gallery_images') && is_array(request()->file('gallery_images'))) {
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
        unset($validated['remove_gallery_images']);
        
        // Log final data before update
        \Log::info('Final data before update - count: ' . count($validated));
        \Log::info('Final target audience values:');
        \Log::info('- target_audience_type: "' . ($validated['target_audience_type'] ?? 'NOT_IN_FINAL') . '"');
        \Log::info('- target_audience_origin: "' . ($validated['target_audience_origin'] ?? 'NOT_IN_FINAL') . '"');
        \Log::info('- target_audience_age: "' . ($validated['target_audience_age'] ?? 'NOT_IN_FINAL') . '"');
        \Log::info('- target_audience_transport: "' . ($validated['target_audience_transport'] ?? 'NOT_IN_FINAL') . '"');
        \Log::info('- target_audience_stay: "' . ($validated['target_audience_stay'] ?? 'NOT_IN_FINAL') . '"');

        // Update the destination with validated data
        \Log::info('Performing destination update...');
        $destination->update($validated);
        \Log::info('Destination update completed');

        // Check values after update
        $fresh = $destination->fresh();
        \Log::info('Values after update (fresh from database):');
        \Log::info('- target_audience_type: "' . $fresh->target_audience_type . '"');
        \Log::info('- target_audience_origin: "' . $fresh->target_audience_origin . '"');
        \Log::info('- target_audience_age: "' . $fresh->target_audience_age . '"');
        \Log::info('- target_audience_transport: "' . $fresh->target_audience_transport . '"');
        \Log::info('- target_audience_stay: "' . $fresh->target_audience_stay . '"');

        \Log::info('=== END ENHANCED DEBUG ===');

        return redirect()->route('editor.destinations.edit', $destination)
            ->with('success', 'Destination updated successfully!');
    }
}
