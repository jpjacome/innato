<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\DashboardSettings;
use Illuminate\Support\Facades\Log;

class ShareSettings
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('ShareSettings middleware running');
        Log::info('Request path: ' . $request->path());
        
        if ($request->is('admin*')) {
            $settings = DashboardSettings::first();
            Log::info('Settings found: ' . ($settings ? 'Yes' : 'No'));
            view()->share('settings', $settings);
        }

        return $next($request);
    }
} 