<?php

use App\Models\Course;
use App\Models\Registration;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

function userWithRole(string $role): User
{
    $user = User::factory()->create();
    $user->assignRole($role);

    return $user;
}

function studentUser(): array
{
    $user = userWithRole('student');
    $student = Student::create([
        'user_id' => $user->id,
        'student_number' => 'TEST/001',
        'programme' => 'Business Computing',
        'year_of_study' => 2,
    ]);

    return [$user, $student];
}

it('renders the shared layout on the administrator pages', function () {
    $admin = userWithRole('administrator');

    foreach (['/admin/dashboard', '/students', '/courses', '/registrations'] as $url) {
        $this->actingAs($admin)->get($url)
            ->assertOk()
            ->assertSee('Makerere University Business School')
            ->assertSee('Student Management System');
    }
});

it('shows only permitted navigation links for each role', function () {
    $admin = userWithRole('administrator');
    $this->actingAs($admin)->get('/admin/dashboard')
        ->assertSee('Students')->assertSee('Registrations')->assertDontSee('My Registrations');

    $lecturer = userWithRole('lecturer');
    $this->actingAs($lecturer)->get('/lecturer/dashboard')
        ->assertSee('My Courses')->assertDontSee('Registrations');

    [$user] = studentUser();
    $this->actingAs($user)->get('/student/dashboard')
        ->assertSee('Available Courses')->assertSee('My Registrations')->assertDontSee('>Courses<', false);
});

it('shows validation errors and keeps old input on the student form', function () {
    $admin = userWithRole('administrator');

    $this->actingAs($admin)->from('/students/create')
        ->post('/students', ['name' => 'Jane', 'email' => 'not-an-email'])
        ->assertRedirect('/students/create')
        ->assertSessionHasErrors(['email', 'student_number', 'programme', 'year_of_study']);

    $this->actingAs($admin)->followingRedirects()->from('/students/create')
        ->post('/students', ['name' => 'Jane', 'email' => 'not-an-email'])
        ->assertSee('Jane');
});

it('shows validation errors on the course form', function () {
    $admin = userWithRole('administrator');

    $this->actingAs($admin)->post('/courses', [])
        ->assertSessionHasErrors(['code', 'title', 'credit_units']);
});

it('creates a course and shows a success flash message', function () {
    $admin = userWithRole('administrator');

    $this->actingAs($admin)->followingRedirects()
        ->post('/courses', ['code' => 'BUC9999', 'title' => 'Test Course', 'credit_units' => 3])
        ->assertSee('Course created successfully.')
        ->assertSee('BUC9999');
});

it('prevents duplicate registrations and shows an error message', function () {
    [$user, $student] = studentUser();
    $course = Course::create(['code' => 'BUC1111', 'title' => 'Dup Test', 'credit_units' => 3]);
    Registration::create(['student_id' => $student->id, 'course_id' => $course->id, 'semester' => 'Semester I 2026/27']);

    $this->actingAs($user)->followingRedirects()->from('/student/register')
        ->post('/student/register', ['course_id' => $course->id, 'semester' => 'Semester I 2026/27'])
        ->assertSee('already registered');

    expect(Registration::count())->toBe(1);
});

it('lets a lecturer see only their own course roster', function () {
    $lecturer = userWithRole('lecturer');
    $other = userWithRole('lecturer');
    $mine = Course::create(['code' => 'BUC2222', 'title' => 'Mine', 'credit_units' => 3, 'lecturer_id' => $lecturer->id]);
    $theirs = Course::create(['code' => 'BUC3333', 'title' => 'Theirs', 'credit_units' => 3, 'lecturer_id' => $other->id]);

    $this->actingAs($lecturer)->get("/lecturer/courses/{$mine->id}/students")->assertOk();
    $this->actingAs($lecturer)->get("/lecturer/courses/{$theirs->id}/students")->assertForbidden();
});

it('blocks students from administrator pages', function () {
    [$user] = studentUser();

    $this->actingAs($user)->get('/students')->assertForbidden();
});
