<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    /**
     * Display the role/permission matrix.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::orderBy('name')->get();

        return view('roles.index', compact('roles', 'permissions'));
    }

    /**
     * Sync the permissions of every role from the submitted matrix.
     */
    public function update(Request $request)
    {
        $matrix = $request->input('permissions', []);

        foreach (Role::all() as $role) {
            $role->syncPermissions($matrix[$role->name] ?? []);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('roles.index')->with('success', 'Permissions updated successfully.');
    }
}
