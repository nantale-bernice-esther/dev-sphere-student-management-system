<!DOCTYPE html>
<!-- PAGE: Index / landing page (guest page, own navbar and footer, no sidebar) -->
<!-- LARAVEL: view resources/views/welcome.blade.php | route GET / (in routes/web.php) -->
<!-- TO CENTRALIZE: this page does not use layouts/app. The 'Head' block can go in layouts/guest.blade.php; 'Navbar' and 'Footer' can become partials -->
<html lang="en" class="scroll-smooth">

<head>
    <!-- Start: Head | CENTRALIZE: same as the other pages -> layout (guest layout for index) -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="icon" type="image/svg+xml" href="assets/img/logo.svg">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['Inter', 'system-ui', 'sans-serif']
                }
            }
        }
    };
    </script>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="assets/js/app.js" defer></script>
    <!-- End: Head -->
</head>

<body class="bg-slate-50 text-slate-900 font-sans antialiased">

    <!-- Start: Navbar | LARAVEL: use route('login') and route('register') for the links -->
    <header class="sticky top-0 z-20 bg-white/90 backdrop-blur border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <!-- Logo and name -->
            <a href="index.html" class="flex items-center gap-3">
                <img src="assets/img/logo.svg" alt="Logo" class="h-9 w-9">
                <span class="font-bold">Student Management System</span>
            </a>

            <!-- Sign in and sign up buttons -->
            <div class="flex items-center gap-2">


                @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                    <x-app-layout>

                    </x-app-layout>
                    @else
                    <a href="{{ url('login') }}"
                        class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-slate-900">Sign in</a>


                    @if (Route::has('register'))
                    <a href="{{ url('register') }}"
                        class="px-4 py-2 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8]">Sign
                        up</a>

                    @endif
                    @endauth
                </nav>
                @endif
            </div>
        </div>
    </header>
    <!-- End: Navbar -->

    <!-- Start: Hero -->
    <section class="max-w-3xl mx-auto px-4 py-16 md:py-24 text-center">
        <!-- Hero text and call to action buttons -->
        <div>
            <p class="text-sm font-medium text-[#2563eb] mb-3">Makerere University Business School</p>
            <h1 class="text-4xl md:text-5xl font-bold tracking-tight leading-tight">Run student records, courses and
                registrations from one place</h1>
            <p class="mt-5 text-lg text-slate-600">Administrators, lecturers and students each get their own dashboard,
                so everyone sees what they need and nothing more.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('register') }}"
                    class="px-6 py-3 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8]">Create
                    an account</a>
                <a href="{{ route('login') }}"
                    class="px-6 py-3 rounded-lg border border-slate-200 bg-white text-sm font-medium text-slate-700 hover:bg-slate-50">Sign
                    in</a>
            </div>
        </div>
    </section>
    <!-- End: Hero -->

    <!-- Start: Features | LARAVEL: static content, no data needed -->
    <section id="features" class="bg-white border-y border-slate-200">
        <div class="max-w-6xl mx-auto px-4 py-16">
            <h2 class="text-3xl font-bold text-center">Everything the school office needs</h2>
            <p class="mt-3 text-center text-slate-600">Four tools that cover the daily work of managing students.</p>
            <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Feature: Students -->
                <div class="rounded-2xl border border-slate-200 p-6">
                    <div class="h-10 w-10 rounded-lg bg-blue-50 text-[#2563eb] flex items-center justify-center"><i
                            data-lucide="users" class="h-5 w-5"></i></div>
                    <h3 class="mt-4 font-semibold">Student records</h3>
                    <p class="mt-2 text-sm text-slate-600">Add, update and find students in seconds.</p>
                </div>
                <!-- Feature: Courses -->
                <div class="rounded-2xl border border-slate-200 p-6">
                    <div class="h-10 w-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center"><i
                            data-lucide="book-open" class="h-5 w-5"></i></div>
                    <h3 class="mt-4 font-semibold">Course catalogue</h3>
                    <p class="mt-2 text-sm text-slate-600">Keep every course, code and lecturer in one list.</p>
                </div>
                <!-- Feature: Registrations -->
                <div class="rounded-2xl border border-slate-200 p-6">
                    <div class="h-10 w-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center"><i
                            data-lucide="clipboard-check" class="h-5 w-5"></i></div>
                    <h3 class="mt-4 font-semibold">Registrations</h3>
                    <p class="mt-2 text-sm text-slate-600">See who registered for which course and when.</p>
                </div>
                <!-- Feature: Role based access -->
                <div class="rounded-2xl border border-slate-200 p-6">
                    <div class="h-10 w-10 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center"><i
                            data-lucide="shield-check" class="h-5 w-5"></i></div>
                    <h3 class="mt-4 font-semibold">Role-based access</h3>
                    <p class="mt-2 text-sm text-slate-600">Each person only sees the pages that match their role.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- End: Features -->

    <!-- Start: Roles -->
    <section id="roles" class="max-w-6xl mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-center">A dashboard for every role</h2>
        <div class="mt-12 grid md:grid-cols-3 gap-6">
            <!-- Role: Admin -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <h3 class="font-semibold">Admin</h3>
                <p class="mt-2 text-sm text-slate-600">Manages students, courses, lecturers and registrations, and
                    controls who can access the system.</p>
            </div>
            <!-- Role: Lecturer -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <h3 class="font-semibold">Lecturer</h3>
                <p class="mt-2 text-sm text-slate-600">Views the courses they teach and the students registered for each
                    one.</p>
            </div>
            <!-- Role: Student -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <h3 class="font-semibold">Student</h3>
                <p class="mt-2 text-sm text-slate-600">Registers for courses and checks their own registrations.</p>
            </div>
        </div>
    </section>
    <!-- End: Roles -->

    <!-- Start: How it works -->
    <section id="how-it-works" class="bg-white border-y border-slate-200">
        <div class="max-w-6xl mx-auto px-4 py-16">
            <h2 class="text-3xl font-bold text-center">Get started in three steps</h2>
            <div class="mt-12 grid md:grid-cols-3 gap-8 text-center">
                <div>
                    <div
                        class="mx-auto h-10 w-10 rounded-full bg-[#2563eb] text-white flex items-center justify-center font-semibold">
                        1</div>
                    <h3 class="mt-4 font-semibold">Create an account</h3>
                    <p class="mt-2 text-sm text-slate-600">Sign up with your name, email and a password.</p>
                </div>
                <div>
                    <div
                        class="mx-auto h-10 w-10 rounded-full bg-[#2563eb] text-white flex items-center justify-center font-semibold">
                        2</div>
                    <h3 class="mt-4 font-semibold">Sign in</h3>
                    <p class="mt-2 text-sm text-slate-600">You land on the dashboard for your role.</p>
                </div>
                <div>
                    <div
                        class="mx-auto h-10 w-10 rounded-full bg-[#2563eb] text-white flex items-center justify-center font-semibold">
                        3</div>
                    <h3 class="mt-4 font-semibold">Start working</h3>
                    <p class="mt-2 text-sm text-slate-600">Manage students, courses or registrations.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- End: How it works -->

    <!-- Start: Final call to action -->
    <section class="max-w-6xl mx-auto px-4 py-16">
        <div class="bg-[#2563eb] rounded-2xl px-8 py-12 text-center text-white">
            <h2 class="text-3xl font-bold">Ready to get started?</h2>
            <p class="mt-3 text-blue-100">Create your account or sign in to open your dashboard.</p>
        </div>
    </section>
    <!-- End: Final call to action -->

    <!-- Start: Footer -->
    <footer class="bg-[#1e3a8a] text-blue-100">
        <div class="max-w-6xl mx-auto px-4 py-6 text-sm">
            &copy; 2026 <span class="font-semibold text-white">Student Management System</span>. All rights reserved.
        </div>
    </footer>
    <!-- End: Footer -->

    <!-- Start: Icons | draws the Lucide icons used on this page -->
    <script>
    lucide.createIcons();
    </script>
    <!-- End: Icons -->

</body>

</html>