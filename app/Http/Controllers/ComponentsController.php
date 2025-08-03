<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeaderSetting;
use App\Models\FooterSetting;
use App\Models\ReviewsSetting;
use Illuminate\Support\Facades\Storage;

class ComponentsController extends Controller
{
    public function editHeader()
    {
        $headerSetting = HeaderSetting::instance();
        return view('admin.components.edit-header', compact('headerSetting'));
    }

    public function updateHeader(Request $request)
    {
        $request->validate([
            'nav_about_text' => 'required|string|max:255',
            'nav_destinations_text' => 'required|string|max:255',
            'nav_experience_text' => 'required|string|max:255',
            'nav_hostal_text' => 'required|string|max:255',
            'nav_contact_text' => 'required|string|max:255',
            'nav_reviews_text' => 'required|string|max:255',
            'search_placeholder' => 'required|string|max:255',
            'header_logo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048', // allow SVG and images
        ]);

        // Handle logo upload
        if ($request->hasFile('header_logo')) {
            $file = $request->file('header_logo');
            $ext = strtolower($file->getClientOriginalExtension());
            $allowed = ['jpeg','jpg','png','gif','svg'];
            if (in_array($ext, $allowed)) {
                $filename = 'logo.' . $ext;
                $targetPath = public_path('assets/imgs/' . $filename);
                try {
                    $file->move(public_path('assets/imgs'), $filename);
                    // Touch the file to update its modified time
                    @touch($targetPath);
                    // Optionally, remove old logo files with other extensions
                    foreach ($allowed as $oldExt) {
                        if ($oldExt !== $ext) {
                            $oldPath = public_path('assets/imgs/logo.' . $oldExt);
                            if (file_exists($oldPath)) {
                                @unlink($oldPath);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error('Header logo upload failed: ' . $e->getMessage());
                    return redirect()->back()->withErrors(['header_logo' => 'Logo upload failed. Please check permissions or file type.']);
                }
            }
        }

        // For now, we'll just update a settings record to store the navigation texts
        // Later we can modify the actual component file programmatically
        $headerSetting = HeaderSetting::firstOrNew();
        $headerSetting->nav_about_text = $request->nav_about_text;
        $headerSetting->nav_destinations_text = $request->nav_destinations_text;
        $headerSetting->nav_experience_text = $request->nav_experience_text;
        $headerSetting->nav_hostal_text = $request->nav_hostal_text;
        $headerSetting->nav_contact_text = $request->nav_contact_text;
        $headerSetting->nav_reviews_text = $request->nav_reviews_text;
        $headerSetting->search_placeholder = $request->search_placeholder;
        $headerSetting->save();

        return redirect()->route('admin.components.edit-header')->with('success', 'Header updated successfully!');
    }

    public function editFooter()
    {
        $footerSetting = FooterSetting::instance();
        return view('admin.components.edit-footer', compact('footerSetting'));
    }

    public function updateFooter(Request $request)
    {
        $request->validate([
            'footer_address' => 'required|string|max:255',
            'footer_phone' => 'required|string|max:255',
            'footer_location' => 'required|string|max:255',
            'footer_email' => 'required|email|max:255',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'newsletter_title' => 'required|string|max:255',
            'newsletter_placeholder' => 'required|string|max:255',
            'newsletter_button_text' => 'required|string|max:255',
            'copyright_text' => 'required|string|max:255',
            'attribution_text' => 'required|string|max:255',
            'attribution_url' => 'required|url',
            'attribution_link_text' => 'required|string|max:255',
            'footer_badge' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $footerSetting = FooterSetting::firstOrNew();
        $footerSetting->address = $request->footer_address;
        $footerSetting->phone = $request->footer_phone;
        $footerSetting->location = $request->footer_location;
        $footerSetting->email = $request->footer_email;
        $footerSetting->twitter_url = $request->twitter_url;
        $footerSetting->instagram_url = $request->instagram_url;
        $footerSetting->newsletter_title = $request->newsletter_title;
        $footerSetting->newsletter_placeholder = $request->newsletter_placeholder;
        $footerSetting->newsletter_button_text = $request->newsletter_button_text;
        $footerSetting->copyright_text = $request->copyright_text;
        $footerSetting->attribution_text = $request->attribution_text;
        $footerSetting->attribution_url = $request->attribution_url;
        $footerSetting->attribution_link_text = $request->attribution_link_text;

        // Handle badge image upload
        if ($request->hasFile('footer_badge')) {
            $badgePath = $request->file('footer_badge')->move(public_path('assets/imgs'), 'badge.png');
        }

        $footerSetting->save();

        return redirect()->route('admin.components.edit-footer')->with('success', 'Footer updated successfully!');
    }

    public function editReviews()
    {
        $reviewsSetting = ReviewsSetting::first();
        return view('admin.components.edit-reviews', compact('reviewsSetting'));
    }

    public function updateReviews(Request $request)
    {
        $request->validate([
            'reviews_title' => 'required|string|max:255',
            'reviews_subtitle' => 'nullable|string|max:255',
            'reviews_data' => 'required|string',
        ]);

        $reviewsSetting = ReviewsSetting::firstOrNew();
        
        $reviewsSetting->title = $request->reviews_title;
        $reviewsSetting->subtitle = $request->reviews_subtitle;
        $reviewsSetting->reviews_data = $request->reviews_data;

        $reviewsSetting->save();

        return redirect()->route('admin.components.edit-reviews')->with('success', 'Reviews updated successfully!');
    }
}
