<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserAccessController extends Controller
{
    /**
     * Display a listing of all users with their roles.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('name')->paginate(10)->withQueryString();
        $roles = Role::orderBy('name')->get();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Replace the role of the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'You cannot change your own role.');
        }

        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')->with('success', 'User role updated successfully.');
    }
}
