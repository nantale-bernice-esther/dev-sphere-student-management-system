<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        Permission::firstOrCreate(['name' => 'manage student']);
        Permission::firstOrCreate(['name' => 'manage courses']);
        Permission::firstOrCreate(['name' => 'manage registrations']);
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'view assigned courses']);
        Permission::firstOrCreate(['name' => 'view registered students']);
        Permission::firstOrCreate(['name' => 'view available courses']);
        Permission::firstOrCreate(['name' => 'view own registrations']);

        // Create roles 
        $administrator = Role::findOrCreate('administrator', 'web');
        $lecturer = Role::findOrCreate('lecturer', 'web');
        $student = Role::findOrCreate('student', 'web');

        //administrator permissions
        $administrator->givePermissionTo('manage student');
        $administrator->givePermissionTo('manage courses');
        $administrator->givePermissionTo('manage registrations');
        $administrator->givePermissionTo('manage users');

        //lecturer permissions
        $lecturer->givePermissionTo('view assigned courses');
        $lecturer->givePermissionTo('view registered students');

        //student permissions
        $student->givePermissionTo('view available courses');
        $student->givePermissionTo('view own registrations');
    }
}
