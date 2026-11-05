<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['code' => 'CSC101', 'title' => 'Introduction to Programming', 'credit_units' => 4, 'lecturer' => 'grace@example.test'],
            ['code' => 'CSC102', 'title' => 'Database Systems', 'credit_units' => 4, 'lecturer' => 'peter@example.test'],
            ['code' => 'CSC103', 'title' => 'Computer Networks', 'credit_units' => 3, 'lecturer' => 'peter@example.test'],
            ['code' => 'CSC104', 'title' => 'Web Development', 'credit_units' => 4, 'lecturer' => 'grace@example.test'],
        ];

        foreach ($courses as $record) {
            $lecturer = User::where('email', $record['lecturer'])->firstOrFail();

            Course::updateOrCreate(
                ['code' => $record['code']],
                [
                    'title' => $record['title'],
                    'credit_units' => $record['credit_units'],
                    'lecturer_id' => $lecturer->id,
                ]
            );
        }
    }
}
