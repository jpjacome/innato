<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DashboardSettings;

class AdminController extends Controller
{
    public function index()
    {
        $adminUsers = User::where('is_admin', true)->get();
        $regularUsers = User::where('is_admin', false)->get();
        $settings = DashboardSettings::first();
        
        return view('admin.dashboard', compact('adminUsers', 'regularUsers', 'settings'));
    }
} 