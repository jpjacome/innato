<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\ElPatioSetting;

class ElPatioController extends Controller
{
    public function edit()
    {
        $elpatioSetting = ElPatioSetting::instance();
        return view('admin.pages.edit-elpatio', compact('elpatioSetting'));
    }

    public function editHeader()
    {
        $elpatioSetting = ElPatioSetting::instance();
        return view('admin.pages.edit-elpatio-header', compact('elpatioSetting'));
    }

    public function editFooter()
    {
        $elpatioSetting = ElPatioSetting::instance();
        return view('admin.pages.edit-elpatio-footer', compact('elpatioSetting'));
    }

    /**
     * Handle header-specific update route and delegate to update()
     */
    public function updateHeader(Request $request)
    {
        return $this->update($request);
    }

    public function updateFooter(Request $request)
    {
        return $this->update($request);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'about_title' => 'nullable|string|max:255',
            'about_title_highlight' => 'nullable|string|max:255',
            'about_text' => 'nullable|string',
            'about2_title' => 'nullable|string|max:255',
            'about2_title_highlight' => 'nullable|string|max:255',
            'about2_text' => 'nullable|string',
            'rooms_title' => 'nullable|string|max:255',
            'rooms_title_highlight' => 'nullable|string|max:255',
            'amenity_icon' => 'nullable|array',
            'amenity_icon.*' => 'nullable|string|max:255',
            'amenity_text' => 'nullable|array',
            'amenity_text.*' => 'nullable|string|max:1024',
            'gallery_text' => 'nullable|array',
            'gallery_text.*' => 'nullable|string|max:1024',
            'hero_background' => 'nullable|file|image|max:5120',
            'loading_logo' => 'nullable|file|image|max:2048',
            'about_image' => 'nullable|file|image|max:4096',
            'about2_image' => 'nullable|file|image|max:4096',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|file|image|max:5120',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|string|max:2048',
            // footer may be submitted as a JSON string in a hidden input; decode later
            'footer' => 'nullable',
        ]);

        $setting = ElPatioSetting::instance();

        // Handle simple text fields
        $setting->about_title = $data['about_title'] ?? $setting->about_title;
    $setting->about_title_highlight = $data['about_title_highlight'] ?? $setting->about_title_highlight;
        $setting->about_text = $data['about_text'] ?? $setting->about_text;
        $setting->about2_title = $data['about2_title'] ?? $setting->about2_title;
    $setting->about2_title_highlight = $data['about2_title_highlight'] ?? $setting->about2_title_highlight;
        $setting->about2_text = $data['about2_text'] ?? $setting->about2_text;
        $setting->rooms_title = $data['rooms_title'] ?? $setting->rooms_title;
    $setting->rooms_title_highlight = $data['rooms_title_highlight'] ?? $setting->rooms_title_highlight;

        // Handle file uploads for single-image fields
        foreach (['hero_background','loading_logo','about_image','about2_image'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                if ($file && $file->isValid()) {
                    $path = $file->store('elpatio', 'public');
                    $setting->{$fileField} = $path;
                }
            }
        }

        // Amenities: build array from amenity_icon[] and amenity_text[]
        $amenities = [];
        $icons = $request->input('amenity_icon', []) ?? [];
        $texts = $request->input('amenity_text', []) ?? [];
        $count = max(count($icons), count($texts));
        for ($i = 0; $i < $count; $i++) {
            $icon = isset($icons[$i]) ? trim($icons[$i]) : '';
            $text = isset($texts[$i]) ? trim($texts[$i]) : '';
            $amenities[] = ['icon' => $icon, 'text' => $text];
        }
        $setting->amenities_list = $amenities;

    // Gallery: handle uploaded files and merge with existing gallery when appropriate
        $gallery = [];
        $existing = $setting->gallery ?? [];
        $uploadedFiles = $request->file('gallery', []);
        $galleryTexts = $request->input('gallery_text', []) ?? [];
        // Inputs that explicitly communicate which existing paths are kept (in form order)
        $galleryExisting = $request->input('gallery_existing', []) ?? [];

        // DEBUG: log incoming gallery-related inputs
        try {
            $uNames = array_map(function($f){ return $f ? ($f->getClientOriginalName() ?? 'unknown') : null; }, (array)$uploadedFiles);
        } catch (\Throwable $e) {
            $uNames = [];
        }
        Log::info('ElPatio update: gallery debug', [
            'uploaded_count' => count((array)$uploadedFiles),
            'uploaded_names' => $uNames,
            'gallery_existing' => $galleryExisting,
            'gallery_text_count' => count((array)$galleryTexts),
            'existing_count' => count((array)$existing),
        ]);

        // DEBUG: log header_menu raw payload for troubleshooting persistence
        try {
            Log::info('ElPatio update: incoming header_menu', [
                'has_header_menu' => $request->has('header_menu'),
                'header_menu_raw' => $request->input('header_menu'),
            ]);
        } catch (\Throwable $_e) {
            // ignore logging errors
        }

        // Determine total slots: use submitted slots (texts/uploads/explicit existing). Do NOT fallback to server-side saved entries.
        $totalSlots = max(count($galleryTexts), count((array)$uploadedFiles), count($galleryExisting));
        for ($i = 0; $i < $totalSlots; $i++) {
            $imagePath = null;

            // Uploaded file takes precedence
            if (isset($uploadedFiles[$i]) && $uploadedFiles[$i] && $uploadedFiles[$i]->isValid()) {
                $imagePath = $uploadedFiles[$i]->store('elpatio', 'public');
            }

            // If no upload, but the form explicitly sent an existing path for this slot, keep it
            if (is_null($imagePath) && isset($galleryExisting[$i]) && $galleryExisting[$i] !== '') {
                $imagePath = $galleryExisting[$i];
            }

            // Only include slots that have an image (either uploaded now or explicitly kept)
            if ($imagePath) {
                $caption = isset($galleryTexts[$i]) ? trim($galleryTexts[$i]) : '';
                $gallery[] = ['image' => $imagePath, 'text' => $caption];
            }
        }
        $setting->gallery = $gallery;

        // Build header_menu either from explicit header_menu input or from menu_label/menu_url arrays
        $headerMenu = null;
        if ($request->has('header_menu')) {
            $headerMenu = $request->input('header_menu');
            // If the form submitted a JSON string, decode it
            if (is_string($headerMenu)) {
                $decoded = json_decode($headerMenu, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $headerMenu = $decoded;
                }
            }
        } elseif ($request->has('menu_label') || $request->has('menu_url')) {
            $labels = $request->input('menu_label', []) ?? [];
            $urls = $request->input('menu_url', []) ?? [];
            $count = max(count((array)$labels), count((array)$urls));
            $built = [];
            for ($i = 0; $i < $count; $i++) {
                $built[] = [
                    'label' => isset($labels[$i]) ? trim($labels[$i]) : '',
                    'url' => isset($urls[$i]) ? trim($urls[$i]) : '#',
                ];
            }
            $headerMenu = $built;
        }

        if (is_array($headerMenu)) {
            // Ensure structure: map to label/url pairs
            $normalized = array_map(function($item){
                return [
                    'label' => is_array($item) ? ($item['label'] ?? '') : (string)($item ?? ''),
                    'url' => is_array($item) ? ($item['url'] ?? '#') : '#',
                ];
            }, $headerMenu);
            $setting->header_menu = $normalized;

            // DEBUG: log the normalized header_menu that will be saved
            try {
                Log::info('ElPatio update: normalized header_menu', ['normalized' => $normalized]);
            } catch (\Throwable $_e) {
                // ignore logging errors
            }
        }

        // Social links: accept an array of links (instagram, tiktok, facebook, whatsapp)
        $socialLinks = $request->input('social_links', null);
        try {
            Log::info('ElPatio update: incoming social_links', ['raw' => $socialLinks]);
        } catch (\Throwable $_e) {
            // ignore
        }
        if (is_array($socialLinks)) {
            // Normalize keys we expect (whatsapp removed)
            $normalized = [
                'instagram' => trim($socialLinks['instagram'] ?? ''),
                'tiktok' => trim($socialLinks['tiktok'] ?? ''),
                'facebook' => trim($socialLinks['facebook'] ?? ''),
            ];
            $setting->social_links = $normalized;
            try {
                Log::info('ElPatio update: normalized social_links', ['normalized' => $normalized]);
            } catch (\Throwable $_e) {}
        }

        // Footer: accept either a structured footer array or discrete footer fields
        $footerInput = $request->input('footer', null);
        // If footer was sent as a JSON string (hidden input), decode it
        if (is_string($footerInput)) {
            $decodedFooter = json_decode($footerInput, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $footerInput = $decodedFooter;
            }
        }
        try { Log::info('ElPatio update: incoming footer', ['raw' => $footerInput]); } catch (\Throwable $_e) {}

        if (is_array($footerInput)) {
            // Normalize expected footer keys
            $normalizedFooter = [
                'address' => trim($footerInput['address'] ?? ''),
                'email' => trim($footerInput['email'] ?? ''),
                'phones' => array_values(array_filter(array_map('trim', (array)($footerInput['phones'] ?? [])))),
                'social_links' => is_array($footerInput['social_links'] ?? null) ? array_map('trim', $footerInput['social_links']) : ($setting->social_links ?? []),
            ];
            $setting->footer = $normalizedFooter;
            try { Log::info('ElPatio update: normalized footer', ['normalized' => $normalizedFooter]); } catch (\Throwable $_e) {}
        } else {
            // Fallback: build from discrete inputs if provided
            $address = trim($request->input('footer_address', $setting->footer['address'] ?? ''));
            $email = trim($request->input('footer_email', $setting->footer['email'] ?? ''));
            // Collect phones from inputs; allow a single input containing multiple phones separated by comma/newline/semicolon/pipe
            $rawPhones = (array) $request->input('footer_phone', $setting->footer['phones'] ?? []);
            $collected = [];
            foreach ($rawPhones as $raw) {
                $r = trim((string)$raw);
                if ($r === '') continue;
                // If the raw string contains common separators, split it into parts
                if (preg_match('/[\r\n,;|]/', $r)) {
                    $parts = preg_split('/[\r\n,;|]+/', $r);
                    foreach ($parts as $p) {
                        $p = trim($p);
                        if ($p !== '') $collected[] = $p;
                    }
                } else {
                    $collected[] = $r;
                }
            }
            $phones = array_values(array_filter($collected));
            $socialLinksInFooter = $request->input('footer_social_links', null);
            $socialNormalized = $setting->social_links ?? [];
            if (is_array($socialLinksInFooter)) {
                $socialNormalized = array_merge($socialNormalized, array_map('trim', $socialLinksInFooter));
            }
            $copyright = trim($request->input('footer_copyright', $setting->footer['copyright'] ?? ''));

            $setting->footer = [
                'address' => $address,
                'email' => $email,
                'phones' => $phones,
                'social_links' => $socialNormalized,
            ];
        }

        $setting->save();

        return back()->with('success', 'El Patio settings updated.');
    }
}
