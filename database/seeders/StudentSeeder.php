<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['email' => 'amina@example.test', 'student_number' => '2026/001', 'programme' => 'Computer Science', 'year_of_study' => 1],
            ['email' => 'brian@example.test', 'student_number' => '2026/002', 'programme' => 'Information Technology', 'year_of_study' => 2],
            ['email' => 'carol@example.test', 'student_number' => '2026/003', 'programme' => 'Computer Science', 'year_of_study' => 1],
            ['email' => 'daniel@example.test', 'student_number' => '2026/004', 'programme' => 'Software Engineering', 'year_of_study' => 3],
            ['email' => 'esther@example.test', 'student_number' => '2026/005', 'programme' => 'Information Technology', 'year_of_study' => 2],
        ];

        foreach ($students as $record) {
            $user = User::where('email', $record['email'])->firstOrFail();

            Student::updateOrCreate(
                ['student_number' => $record['student_number']],
                [
                    'user_id' => $user->id,
                    'programme' => $record['programme'],
                    'year_of_study' => $record['year_of_study'],
                ]
            );
        }
    }
}
