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

        // Add reservations for dashboard table (paginated)
        $reservations = \App\Models\Reservation::with('destination')->latest()->paginate(10);

        return view('admin.dashboard', compact('adminUsers', 'regularUsers', 'settings', 'reservations'));
    }
} 