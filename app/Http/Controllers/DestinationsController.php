<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DestinationsSetting;

class DestinationsController extends Controller
{
    public function show()
    {
        $destinations = \App\Models\Destination::where('status', 'active')->orderBy('title')->get();
        return view('destinations', compact('destinations'));
    }

    public function showRegion($region)
    {
        $region = ucfirst(strtolower($region));
        $destinations = \App\Models\Destination::where('status', 'active')
            ->where('region', $region)
            ->orderBy('title')
            ->get();
        return view('destinations', compact('destinations', 'region'));
    }

    public function edit()
    {
        $destinationsSetting = DestinationsSetting::instance();
        return view('admin.pages.edit-destinations', compact('destinationsSetting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'banner_title' => 'required|string|max:255',
            'banner_description' => 'required|string',
            'headline_title' => 'nullable|string|max:255',
            'destinations_title' => 'required|string|max:255',
            'destinations_button_text' => 'required|string|max:255',
        ]);

        $data = [
            'banner_title' => $request->input('banner_title'),
            'banner_description' => $request->input('banner_description'),
            'headline_title' => $request->input('headline_title'),
            'destinations_title' => $request->input('destinations_title'),
            'destinations_button_text' => $request->input('destinations_button_text'),
        ];

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerPath = $bannerImage->store('destinations', 'public');
            $data['banner_image'] = $bannerPath;
        }

        // Handle headline cards (JSON)
        $headlineCards = $request->input('headline_cards', []);
        $existingSetting = DestinationsSetting::instance();
        $existingCards = [];
        if ($existingSetting && $existingSetting->headline_cards) {
            $existingCards = json_decode($existingSetting->headline_cards, true) ?: [];
        }
        if (is_array($headlineCards)) {
            foreach ($headlineCards as $i => &$card) {
                if ($request->hasFile("headline_cards.$i.image")) {
                    $img = $request->file("headline_cards.$i.image");
                    $imgPath = $img->store('destinations', 'public');
                    $card['image'] = $imgPath;
                } elseif (isset($existingCards[$i]['image'])) {
                    $card['image'] = $existingCards[$i]['image'];
                }
            }
        }
        $data['headline_cards'] = json_encode($headlineCards);

        $destinationsSetting = DestinationsSetting::instance();
        if ($destinationsSetting) {
            $destinationsSetting->update($data);
        } else {
            DestinationsSetting::create($data);
        }

        return redirect()->route('admin.pages.edit-destinations')
            ->with('success', 'Destinations page updated successfully!');
    }
}
