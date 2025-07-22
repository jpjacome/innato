<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EditorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Allow both admins and editors, but log what's happening
        if (!$user->isAdmin() && !$user->isEditor()) {
            abort(403, 'You must be an admin or editor to access this area.');
        }

        // Add debug info to help troubleshoot
        if (config('app.debug')) {
            logger()->info('EditorMiddleware: User accessing editor area', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $user->role,
                'is_admin' => $user->isAdmin(),
                'is_editor' => $user->isEditor(),
                'destination_id' => $user->destination_id,
                'url' => $request->url()
            ]);
        }

        return $next($request);
    }
}
