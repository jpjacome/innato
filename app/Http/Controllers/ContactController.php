<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactSetting;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function show()
    {
        $contactSetting = ContactSetting::first();
        return view('contact', compact('contactSetting'));
    }

    public function edit()
    {
        $contactSetting = ContactSetting::first();
        return view('admin.pages.edit-contact', compact('contactSetting'));
    }

    public function update(Request $request)
    {
        $contactSetting = ContactSetting::first() ?? new ContactSetting();
        $contactSetting->banner_title = $request->input('banner_title');
        $contactSetting->banner_description = $request->input('banner_description');
        $contactSetting->button_text = $request->input('button_text');
        $contactSetting->newsletter_label = $request->input('newsletter_label');
        if ($request->hasFile('banner_image')) {
            $path = $request->file('banner_image')->store('contact', 'public');
            $contactSetting->banner_image = $path;
        }
        $contactSetting->save();
        return redirect()->route('admin.contact.edit')->with('success', 'Contacto actualizado correctamente.');
    }
}
