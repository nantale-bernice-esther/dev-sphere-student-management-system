<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Demo Administrator', 'email' => 'admin@example.test', 'role' => 'administrator'],
            ['name' => 'Grace Nanyonga', 'email' => 'grace@example.test', 'role' => 'lecturer'],
            ['name' => 'Peter Okello', 'email' => 'peter@example.test', 'role' => 'lecturer'],
            ['name' => 'Amina Kato', 'email' => 'amina@example.test', 'role' => 'student'],
            ['name' => 'Brian Mugisha', 'email' => 'brian@example.test', 'role' => 'student'],
            ['name' => 'Carol Namusoke', 'email' => 'carol@example.test', 'role' => 'student'],
            ['name' => 'Daniel Ouma', 'email' => 'daniel@example.test', 'role' => 'student'],
            ['name' => 'Esther Nakato', 'email' => 'esther@example.test', 'role' => 'student'],
        ];

        foreach ($users as $record) {
            $user = User::firstOrNew(['email' => $record['email']]);

            // Set the password only when creating a new account.
            if (! $user->exists) {
                $user->name = $record['name'];
                $user->password = Hash::make('DemoPass2026!');
                $user->email_verified_at = now();
                $user->save();
            }

            $user->assignRole($record['role']);
        }
    }
}
