<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use App\View\Components\AdminLayout;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS on production
        if(config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        
        // Set the application URL root path for subdirectory installations
        $appUrl = config('app.url');
        $urlParts = parse_url($appUrl);
        
        if (isset($urlParts['path']) && $urlParts['path'] !== '/') {
            URL::forceRootUrl($appUrl);
        }
        
        Blade::component('control-panel-layout', \App\View\Components\ControlPanelLayout::class);
    }
}
