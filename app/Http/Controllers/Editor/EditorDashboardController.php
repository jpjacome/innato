<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\DashboardSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditorDashboardController extends Controller
{
    public function index()
    {
        $dashboardSettings = DashboardSettings::first();
        if (!$dashboardSettings) {
            $dashboardSettings = new DashboardSettings([
                'primary_color' => '#4F46E5',
                'secondary_color' => '#818CF8',
                'accent_color' => '#6366f1',
                'dashboard_title' => 'Editor Dashboard'
            ]);
        }

        $user = Auth::user();
        
        // Debug logging
        logger()->info('Editor Dashboard Access', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'is_admin' => $user->isAdmin(),
            'is_editor' => $user->isEditor(),
            'destination_id' => $user->destination_id
        ]);
        
        // Get destinations that the editor can manage
        if ($user->isAdmin()) {
            // Admins can see all destinations
            $destinations = Destination::where('status', 'active')->get();
            logger()->info('Admin user - showing all destinations', ['count' => $destinations->count()]);
        } else {
            // Editors can only see their assigned destination
            $destinations = Destination::where('id', $user->destination_id)
                ->where('status', 'active')
                ->get();
            logger()->info('Editor user - showing assigned destination only', [
                'assigned_destination_id' => $user->destination_id,
                'count' => $destinations->count()
            ]);
        }

        $destinationsCount = $destinations->count();

        // Fetch reservations for these destinations
        $destinationIds = $destinations->pluck('id');
        $reservations = \App\Models\Reservation::whereIn('destination_id', $destinationIds)
            ->with('destination')
            ->paginate(10);

        return view('editor.dashboard', [
            'settings' => $dashboardSettings,
            'destinations' => $destinations,
            'destinationsCount' => $destinationsCount,
            'reservations' => $reservations
        ]);
    }
}
