# Dev Sphere — Student Management System

A Laravel web application for managing students, courses, and course registrations with role-based access for administrators, lecturers, and students.

## Features

- **Role-based dashboards** — each signed-in user lands on `/dashboard`, which resolves to the right view for their role (administrator, lecturer, or student).
- **Administrator** — full CRUD for students, courses, and lecturers; manages registrations (add/delete, with duplicate prevention); views the role/permission matrix and assigns roles to users.
- **Lecturer** — sees assigned courses with live registration counts, and the roster of students registered for each course.
- **Student** — browses the course catalog, self-registers for courses per semester, and reviews own registrations and total credit units.
- **Public registration** creates student accounts only; an administrator can also create accounts from the admin screens.

## Tech Stack

| Layer        | Choice                                              |
|--------------|-----------------------------------------------------|
| Framework    | Laravel 13 (PHP ^8.3)                               |
| Authentication | Laravel Jetstream + Fortify (Livewire components) |
| Authorization | spatie/laravel-permission v8 (`role` / `permission` middleware) |
| Views        | Blade templates extending a centralized `layouts.app` layout with shared partials (sidebar, navigation) |
| Styling      | Tailwind CSS, Lucide icons                          |
| Testing      | Pest 5                                              |
| Formatting   | Laravel Pint                                        |
| Database     | SQLite by default (`.env.example` ships `DB_CONNECTION=sqlite`) |

## Getting Started

Requires PHP 8.3+ and Composer.

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite   # SQLite is the default connection
php artisan migrate --seed
php artisan serve
```

The app is then available at http://127.0.0.1:8000.

### Demo Accounts

The seeder creates one account per role. All demo passwords are `DemoPass2026!`:

| Role          | Email                  |
|---------------|------------------------|
| Administrator | `admin@example.test`   |
| Lecturer      | `grace@example.test`   |
| Student       | `amina@example.test`   |

Additional seeded lecturers/students exist (`peter@`, `brian@`, `carol@`, `daniel@`, `esther@example.test`).

## Data Model

- `users` — accounts; one per person, carrying roles via spatie/laravel-permission.
- `students` — academic profile linked to a user (`student_number`, programme, year of study).
- `courses` — owned by a lecturer (`lecturer_id`), with `code`, `title`, `credit_units`, semester.
- `registrations` — pivot between students and courses with a `semester` column and a unique constraint on `(student_id, course_id, semester)` to prevent duplicate enrollment.

## Routes Overview

| Area          | Paths                                                                 |
|---------------|-----------------------------------------------------------------------|
| Public        | `/` welcome page; `/login`, `/register` via Fortify                    |
| Shared        | `/dashboard` — role-resolved landing page for every authenticated user |
| Administrator | `/admin/*` canonical routes (students, courses, registrations, lecturers, roles, users) plus unprefixed aliases so legacy links keep working |
| Lecturer      | `/lecturer/dashboard`, `/lecturer/courses`, `/lecturer/courses/{id}/students` |
| Student       | `/student/dashboard`, `/student/courses`, `/student/register`, `/student/registrations` |

Run `php artisan route:list` for the complete table.

## Testing & Code Style

```bash
php artisan test            # Pest suite (feature tests for auth, layouts, navigation, validation, registration rules, admin access)
vendor/bin/pint             # fix code style
vendor/bin/pint --test      # check only
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
