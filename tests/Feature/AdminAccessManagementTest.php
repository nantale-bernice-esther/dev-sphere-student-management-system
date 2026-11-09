<?php

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

function adminUser(): User
{
    $user = User::factory()->create();
    $user->assignRole('administrator');

    return $user;
}

it('renders the lecturer, roles and users pages for an administrator', function () {
    $admin = adminUser();

    foreach (['/lecturers', '/roles', '/users'] as $url) {
        $this->actingAs($admin)->get($url)
            ->assertOk()
            ->assertSee('Makerere University Business School')
            ->assertSee('Student Management System');
    }
});

it('creates a lecturer with the lecturer role and shows a success flash', function () {
    $admin = adminUser();

    $this->actingAs($admin)->followingRedirects()
        ->post('/lecturers', [
            'name' => 'Test Lecturer',
            'email' => 'test.lecturer@example.test',
            'password' => 'SecretPass123',
        ])
        ->assertSee('Lecturer created successfully.')
        ->assertSee('Test Lecturer');

    expect(User::where('email', 'test.lecturer@example.test')->first()->hasRole('lecturer'))->toBeTrue();
});

it('validates the lecturer form before saving', function () {
    $admin = adminUser();

    $this->actingAs($admin)->post('/lecturers', [])
        ->assertSessionHasErrors(['name', 'email', 'password']);
});

it('updates a lecturer without changing the password when left blank', function () {
    $admin = adminUser();
    $lecturer = User::factory()->create(['password' => 'OriginalPass123']);
    $lecturer->assignRole('lecturer');

    $this->actingAs($admin)->put("/lecturers/{$lecturer->id}", [
        'name' => 'Renamed Lecturer',
        'email' => $lecturer->email,
        'password' => '',
    ])->assertRedirect(route('lecturers.index'));

    $lecturer->refresh();
    expect($lecturer->name)->toBe('Renamed Lecturer');
});

it('forbids deleting your own lecturer account', function () {
    $admin = adminUser();

    $this->actingAs($admin)->delete("/lecturers/{$admin->id}")
        ->assertRedirect(route('lecturers.index'))
        ->assertSessionHas('error');

    expect(User::find($admin->id))->not->toBeNull();
});

it('syncs role permissions from the matrix', function () {
    $admin = adminUser();
    $student = User::factory()->create();
    $student->assignRole('student');

    $this->actingAs($admin)->put('/roles', [
        'permissions' => [
            'student' => ['view available courses', 'manage courses'],
            'lecturer' => [],
            'administrator' => ['manage student', 'manage courses', 'manage registrations', 'manage users', 'manage lecturers', 'manage roles'],
        ],
    ])->assertRedirect(route('roles.index'));

    $studentRolePerms = Role::findByName('student')->permissions->pluck('name')->sort()->values()->all();
    expect($studentRolePerms)->toBe(['manage courses', 'view available courses']);

    expect(Role::findByName('lecturer')->permissions->count())->toBe(0);
});

it('changes a user role from the access page and protects your own role', function () {
    $admin = adminUser();
    $user = User::factory()->create();
    $user->assignRole('student');

    $this->actingAs($admin)->put("/users/{$user->id}", ['role' => 'lecturer'])
        ->assertRedirect(route('users.index'))
        ->assertSessionHas('success');

    expect($user->fresh()->hasRole('lecturer'))->toBeTrue()
        ->and($user->fresh()->hasRole('student'))->toBeFalse();

    $this->actingAs($admin)->put("/users/{$admin->id}", ['role' => 'student'])
        ->assertSessionHas('error');

    expect($admin->fresh()->hasRole('administrator'))->toBeTrue();
});

it('blocks non-administrators from the access management pages', function () {
    $lecturer = User::factory()->create();
    $lecturer->assignRole('lecturer');

    foreach (['/lecturers', '/roles', '/users'] as $url) {
        $this->actingAs($lecturer)->get($url)->assertForbidden();
    }
});
