<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:super_admin,moderator,editor'],
        ]);

        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        return back()->with('success', 'Administrator account created successfully.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:super_admin,moderator,editor'],
            'is_active' => ['required', 'boolean'],
        ]);

        // Prevent Demoting/Deactivating Self
        if (auth()->id() === $user->id) {
            if ($validated['role'] !== 'super_admin' || !$validated['is_active']) {
                return back()->withErrors(['role' => 'You cannot demote or deactivate your own active session.']);
            }
        }

        $user->update($validated);

        return back()->with('success', 'Administrator account updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent Self-deletion
        if (auth()->id() === $user->id) {
            return back()->withErrors(['delete' => 'You cannot delete your own active session.']);
        }

        $user->delete();

        return back()->with('success', 'Administrator account deleted successfully.');
    }
}
