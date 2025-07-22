<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EditorAuthenticatedSessionController extends Controller
{
    /**
     * Display the login view (serves as main login).
     */
    public function create(): View
    {
        return view('auth.editor-login');
    }

    /**
     * Handle an incoming editor authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // No role restriction - editors and guests can both login here
        $user = Auth::user();
        
        $request->session()->regenerate();

        // Debug logging
        logger()->info('Editor login successful', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'is_admin' => $user->isAdmin(),
            'is_editor' => $user->isEditor(),
        ]);

        // Redirect based on user role
        if ($user->isAdmin()) {
            logger()->info('Redirecting admin to admin dashboard');
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->isEditor()) {
            logger()->info('Redirecting editor to editor dashboard');
            return redirect()->intended(route('editor.dashboard'));
        } else {
            // Regular user - redirect to basic dashboard
            logger()->info('Redirecting regular user to dashboard');
            return redirect()->intended(route('dashboard'));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
