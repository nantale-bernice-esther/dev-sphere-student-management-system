<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        if (! class_exists(Role::class) || ! method_exists(User::class, 'assignRole')) {
            throw new RuntimeException('Complete the Spatie package setup and add HasRoles to User before seeding.');
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $roles = ['administrator', 'lecturer', 'student'];

        foreach ($roles as $role) {
            Role::findOrCreate($role, 'web');
        }
    }
}
