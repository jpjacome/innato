<?php

namespace App\Http\Controllers;

use App\Models\HeroSetting;
use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $settings = HeroSetting::first();
        $adminUsers = User::where('is_admin', true)->get();
        $regularUsers = User::where('is_admin', false)->get();

        // For debugging
        \Log::info('Admin Users:', $adminUsers->toArray());
        \Log::info('Regular Users:', $regularUsers->toArray());

        return view('welcome', compact('settings', 'adminUsers', 'regularUsers'));
    }
} 