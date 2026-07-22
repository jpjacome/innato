<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\DashboardSettings;

class ShareSettings
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('admin*')) {
            $settings = DashboardSettings::first();
            view()->share('settings', $settings);
        }

        return $next($request);
    }
} 