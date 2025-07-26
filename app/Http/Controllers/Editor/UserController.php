<?php
namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Only show the current logged-in editor
        $users = [$user];
        return view('editor.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $authUser = auth()->user();
        // Editors can only edit themselves
        if ($authUser->id != $user->id) {
            \Log::info('Editor user edit access denied', [
                'auth_user_id' => $authUser->id,
                'requested_user_id' => $user->id
            ]);
            abort(403, 'Unauthorized action.');
        }

        return view('editor.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $authUser = auth()->user();
        // Editors can only update themselves
        if ($authUser->id != $user->id) {
            \Log::info('Editor user update access denied', [
                'auth_user_id' => $authUser->id,
                'requested_user_id' => $user->id
            ]);
            abort(403, 'Unauthorized action.');
        }

        // Log the incoming request data
        \Log::info('Editor user update request data', [
            'user_id' => $user->id,
            'request_data' => $request->all()
        ]);

        // Ensure editors can't change their role
        $request->merge(['role' => 'editor']);

        // If password is filled but password_confirmation is not, set password_confirmation to match password
        if ($request->filled('password') && !$request->filled('password_confirmation')) {
            $request->merge(['password_confirmation' => $request->password]);
            \Log::info('Auto-filled password_confirmation', [
                'user_id' => $user->id,
                'password_length' => strlen($request->password)
            ]);
        }

        // Create validation rules array
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ];

        // Only apply password validation if the password field is filled
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $request->validate($rules);

        // Log after validation
        \Log::info('Editor user update validation passed', [
            'user_id' => $user->id
        ]);

        // Update user data
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'editor',
            'is_admin' => false
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Log the data being used for update
        \Log::info('Editor user update data prepared', [
            'user_id' => $user->id,
            'update_data' => array_diff_key($userData, ['password' => '']) // Don't log password
        ]);

        try {
            // Get current user data for comparison
            $oldData = [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'is_admin' => $user->is_admin
            ];

            $result = $user->update($userData);

            // Log the update result and data comparison
            \Log::info('Editor user update result', [
                'user_id' => $user->id,
                'success' => $result,
                'old_data' => $oldData,
                'new_data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'is_admin' => $user->is_admin
                ]
            ]);
        } catch (\Exception $e) {
            // Log any exceptions that occur during update
            \Log::error('Editor user update exception', [
                'user_id' => $user->id,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el perfil: ' . $e->getMessage());
        }

        return redirect()->route('editor.users.index')
            ->with('success', 'Perfil actualizado exitosamente.');
    }
}
