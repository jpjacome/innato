<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            $users = User::all();
            return view('admin.users.index', compact('users'));
        } else {
            $users = collect([$user]);
            return view('editor.users.index', compact('users'));
        }
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function edit(User $user)
    {
        $authUser = auth()->user();
        // Admins can edit any user, editors can only edit themselves
        if ($authUser->isAdmin()) {
            return view('admin.users.edit', compact('user'));
        } elseif ($authUser->isEditor() && $authUser->id == $user->id) {
            return view('editor.users.edit', compact('user'));
        }

        // Debug information
        \Log::info('User edit access denied', [
            'auth_user_id' => $authUser->id,
            'auth_user_role' => $authUser->role,
            'requested_user_id' => $user->id,
            'comparison_result' => $authUser->id == $user->id
        ]);

        abort(403, 'Unauthorized action.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,editor,regular']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_admin' => $request->role === 'admin'
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function update(Request $request, User $user)
    {
        $authUser = auth()->user();

        // Check permissions: admins can update any user, editors can only update themselves
        if (!$authUser->isAdmin() && (!$authUser->isEditor() || $authUser->id != $user->id)) {
            \Log::info('User update access denied', [
                'auth_user_id' => $authUser->id,
                'auth_user_role' => $authUser->role,
                'requested_user_id' => $user->id
            ]);
            abort(403, 'Unauthorized action.');
        }

        // For editors, ensure they can't change their role
        if ($authUser->isEditor() && $authUser->id == $user->id) {
            $request->merge(['role' => 'editor']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,editor,regular',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        // Update user data
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_admin' => $request->role === 'admin'
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting the last admin
        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return back()->with('error', 'Cannot delete the last admin user.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
