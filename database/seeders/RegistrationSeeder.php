<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $registrations = [
            ['student_number' => '2026/001', 'course_code' => 'CSC101'],
            ['student_number' => '2026/001', 'course_code' => 'CSC102'],
            ['student_number' => '2026/001', 'course_code' => 'CSC104'],
            ['student_number' => '2026/002', 'course_code' => 'CSC101'],
            ['student_number' => '2026/002', 'course_code' => 'CSC103'],
            ['student_number' => '2026/003', 'course_code' => 'CSC102'],
            ['student_number' => '2026/003', 'course_code' => 'CSC104'],
            ['student_number' => '2026/004', 'course_code' => 'CSC104'],
            ['student_number' => '2026/005', 'course_code' => 'CSC103'],
        ];

        foreach ($registrations as $record) {
            $student = Student::where('student_number', $record['student_number'])->firstOrFail();
            $course = Course::where('code', $record['course_code'])->firstOrFail();

            Registration::firstOrCreate([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'semester' => '2026/2027 Semester 1',
            ]);
        }
    }
}
