<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $lecturer = User::firstOrCreate([
            'email' => 'lecturer@gmail.com',
        ], [
            'name' => 'Lecturer',
            'password' => Hash::make('password'),
        ]);
        $lecturer->assignRole('lecturer');

        $student = User::firstOrCreate([
            'email' => 'student@gmail.com',
        ], [
            'name' => 'Student', 
            'password' => Hash::make('password'),
        ]);
        $student->assignRole('student');
    }
}
