<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterNotification;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        // Honeypot check
        if ($request->filled('website')) {
            return back()->with('error', 'Spam detected.');
        }

        // Rate limiting: 1 request per minute per IP
        if (cache()->has('newsletter_' . $request->ip())) {
            return back()->with('error', 'Please wait before subscribing again.');
        }
        cache()->put('newsletter_' . $request->ip(), true, 60);

        // Validate email and block disposable domains
        $request->validate([
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $disposable = ['mailinator.com', 'tempmail.com', '10minutemail.com', 'guerrillamail.com'];
                    $domain = strtolower(substr(strrchr($value, '@'), 1));
                    if (in_array($domain, $disposable)) {
                        $fail('Disposable email addresses are not allowed.');
                    }
                }
            ]
        ]);

        $subscriberEmail = $request->input('email');
        // Send notification to admin
        Mail::to(config('mail.from.address'))->send(new NewsletterNotification($subscriberEmail));
        // Send confirmation to subscriber
        Mail::to($subscriberEmail)->send(new \App\Mail\NewsletterConfirmation($subscriberEmail));

        return back()->with('success', 'Thank you for subscribing!');
    }
}