<!DOCTYPE html>
{{-- PAGE: Lecturer dashboard --}}
{{-- LARAVEL: view resources/views/dashboard/lecturer.blade.php  (one dashboard view PER role, no merging; the controller picks the right one) | route GET /dashboard (the same route as the admin dashboard) | controller DashboardControllerindex -> return view('dashboard.lecturer') when the user is a lecturer | data $assignedCourses (with students_count) --}}
{{-- TO CENTRALIZE THIS FILE: keep only the block 'Page content', wrap it in extends('layouts.app') section('content') ... endsection, delete everything else (it lives in the layout and partials) --}}
<html lang="en">

<head>
    {{-- Start: Head | CENTRALIZE: same on every page except the title -> layouts/app.blade.php (title becomes yield('title')) --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Management System</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="{{ asset('assets/js/app.js') }}" defer></script>
    {{-- End: Head --}}
</head>

<body class="bg-white text-slate-900 font-sans antialiased min-h-screen">
    {{-- Start: Sidebar toggle (checkbox, no JavaScript) | CENTRALIZE: same on every page -> layouts/app.blade.php --}}
    <input type="checkbox" id="sidebar-toggle" class="peer hidden">
    <label for="sidebar-toggle" class="fixed inset-0 bg-slate-900/30 z-30 hidden peer-checked:block sm:!hidden"></label>
    {{-- End: Sidebar toggle --}}

    {{-- Start: Header | CENTRALIZE: same on every page -> resources/views/partials/header.blade.php, then include('partials.header') --}}
    <header class="fixed top-0 z-50 w-full bg-white border-b border-slate-200">
        <div class="px-2 py-2 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <label for="sidebar-toggle"
                        class="inline-flex items-center p-2 text-slate-500 rounded-lg sm:hidden hover:bg-slate-100 cursor-pointer">
                        <span class="sr-only">Open sidebar</span>
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </label>
                    <a href="{{ route('lecturer.dashboard') }}" class="flex items-center ms-2 md:me-8">
                        <img src="{{ asset('assets/img/logo.svg') }}" alt="Student Management System"
                            class="h-10 w-10 me-3">
                        <div class="flex flex-col">
                            <span class="font-semibold text-slate-900 text-base">Student Management System</span>
                            <span class="text-xs text-slate-500">Makerere University Business School</span>
                        </div>
                    </a>
                </div>
                {{-- Start: Header user menu | --}}
                <div class="menu-dropdown relative">


                    <div class="hidden md:block text-left mr-1">
                        <x-app-layout>

                        </x-app-layout>
                    </div>


                </div>
                {{-- End: Header user menu --}}
            </div>
        </div>
    </header>
    {{-- End: Header --}}

    {{-- Start: Sidebar | THIS prototype shows only the links for this role. In Laravel keep ONE sidebar file with ALL links (see _reference/sidebar-all-links.html); can hides the links this user may not use -> resources/views/partials/sidebar.blade.php --}}
    <aside
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 -translate-x-full peer-checked:translate-x-0 sm:translate-x-0 bg-white border-r border-slate-200 flex flex-col">
        <div class="flex-1 px-3 py-4 overflow-y-auto sidebar-scrollbar">
            {{-- Start: Sidebar group - Main --}}
            <div class="space-y-1 mb-5">
                <p class="px-3 text-xs font-semibold text-slate-400 uppercase mb-2">Main</p>
                {{-- Link: Dashboard | show with no permission (every role) | href route('dashboard') | active when request()->routeIs('dashboard') --}}
                <a href="{{ route('lecturer.dashboard') }}"
                    class="sidebar-item border-l-3 border-[#2563eb] bg-blue-50 text-[#2563eb] flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3"><i
                        data-lucide="layout-dashboard" class="w-5 h-5 text-[#2563eb] transition-colors"></i><span
                        class="ms-3 text-sm font-medium">Dashboard</span></a>
            </div>
            {{-- End: Sidebar group - Main --}}
            {{-- Start: Sidebar group - Teaching --}}
            <div class="space-y-1 mb-5">
                <p class="px-3 text-xs font-semibold text-slate-400 uppercase mb-2">Teaching</p>
                {{-- Link: My courses | show with can('view assigned courses') | href route('lecturer.courses') | active when request()->routeIs('lecturer.courses*') --}}
                <a href="{{ route('lecturer.courses') }}"
                    class="sidebar-item border-l-3 border-transparent text-slate-500 flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3"><i
                        data-lucide="presentation"
                        class="w-5 h-5 text-slate-400 group-hover:text-[#2563eb] transition-colors"></i><span
                        class="ms-3 text-sm font-medium">My courses</span></a>
            </div>
            {{-- End: Sidebar group - Teaching --}}
        </div>
        {{-- Start: Sidebar user card | LARAVEL: same auth()->user() values as the header user menu --}}
        <div class="mt-auto border-t border-slate-200 p-4">
            <div class="flex items-center gap-3 mb-3">
                 {{-- Initials circle: takes the first 2 letters of the name and makes them capital. --}}
        <div class="w-10 h-10 shrink-0 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[#2563eb] text-sm font-semibold">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>

        <div class="min-w-0">
            {{-- Name of the logged-in user, read from the users table. --}}
            <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name }}</p>

            {{-- Email of the logged-in user, read from the users table. --}}
            <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
        </div>
    </div>

    {{-- Role badge. This page is only for lecturers, so the text can stay fixed. --}}
    <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-lg border border-slate-200">
        <i data-lucide="presentation" class="w-4 h-4 text-[#2563eb]"></i>
        <span class="text-xs font-semibold text-slate-800 uppercase tracking-wide">Lecturer</span>
    </div>
        </div>
        {{-- End: Sidebar user card --}}
    </aside>
    {{-- End: Sidebar --}}

    {{-- Start: Main content | CENTRALIZE: this wrapper stays in layouts/app.blade.php --}}
    <div class="pt-16 sm:pl-64 min-h-screen flex flex-col">
        <main class="flex-1 pb-8 px-4 sm:px-8 lg:px-10 pt-6">

            {{-- Start: Flash messages | PROTOTYPE: empty on page load; assets/js/app.js fills it when you click Save, Delete or Register, and it is gone after a reload. CENTRALIZE: partials/flash.blade.php. LARAVEL: the controller sets ->with('success', '...') and the partial prints it with if(session('success')) ... endif --}}
            <div id="flash-messages" class="mb-4 space-y-2"></div>
            {{-- End: Flash messages --}}

            {{-- Start: Page content | UNIQUE on every page -> stays in this page's own file (section('content')); in the layout it is just yield('content') --}}

            {{-- Start: Page heading | main button: wrap in can('manage ...') --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
                <div>
                  {{-- Display the name of the lecturer who is currently logged in. --}}
<h1 class="text-2xl font-bold text-slate-900">
    Welcome, {{ auth()->user()->name }}
</h1>
                    <p class="text-slate-500 mt-1">Your assigned courses at a glance.</p>
                </div>
            </div>
            {{-- End: Page heading --}}

            {{-- Start: Stats cards | --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-2 gap-4 mb-8">
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center"><i
                                data-lucide="presentation" class="w-5 h-5 text-[#2563eb]"></i></div>
                        <div>
                            {{-- Display the number of courses assigned to the logged-in lecturer. --}}
<p class="text-2xl font-bold">{{ $courseCount }}</p>

{{-- Explain what the number represents. --}}
<p class="text-sm text-slate-500">Assigned courses</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center"><i
                                data-lucide="users" class="w-5 h-5 text-emerald-600"></i></div>
                        <div>
                           {{-- Display the total student registrations across the lecturer's courses. --}}
<p class="text-2xl font-bold">{{ $studentCount }}</p>

{{-- Explain what the number represents. --}}
<p class="text-sm text-slate-500">Registered students</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End: Stats cards --}}

            {{-- Start: Assigned courses --}}
            <h2 class="text-lg font-semibold mb-3">Assigned courses</h2>
            {{-- Start: Table - mine | --}}
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table id="mine" class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50">
                                <th class="py-3 px-4 text-left text-sm font-semibold text-slate-500">Code</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-slate-500">Title</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-slate-500">Students</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-slate-500">Open</th>
                            </tr>
                        </thead>
                       
<tbody>

    {{-- Go through every course assigned to the logged-in lecturer. --}}
    @forelse ($assignedCourses as $course)

        {{-- Display one table row for each assigned course. --}}
        <tr class="border-b border-slate-200 hover:bg-slate-50">

            {{-- Display the course code from the database. --}}
            <td class="py-3 px-4 text-sm">
                {{ $course->code }}
            </td>

            {{-- Display the course title from the database. --}}
            <td class="py-3 px-4 text-sm">
                {{ $course->title}}
            </td>

            {{-- Display the number of students registered for this course. --}}
            <td class="py-3 px-4 text-sm">
                {{ $course->students_count }}
            </td>

            {{-- Provide a link to view students registered for this course. --}}
            <td class="py-3 px-4 text-sm">

               
{{-- Pass the selected course ID to the lecturer course-students route. --}}
<a href="{{ route('lecturer.courses.students', $course->id) }}"
   class="text-[#2563eb] hover:underline font-medium">

    {{-- Display the word View to open the selected course. --}}
    View

</a>


               

            </td>

        </tr>

    @empty

        {{-- Display this message when the lecturer has no assigned courses. --}}
        <tr>
            <td colspan="4"
                class="py-6 px-4 text-center text-sm text-slate-500">

                No courses have been assigned to you yet.

            </td>
        </tr>

    @endforelse

</tbody>

                    </table>
                </div>
            </div>
            {{-- End: Table - mine --}}

            {{-- End: Assigned courses --}}

            {{-- End: Page content --}}

        </main>
        {{-- Start: Footer | CENTRALIZE: same on every page -> resources/views/partials/footer.blade.php, then include('partials.footer') --}}
        <footer class="bg-[#1e3a8a] mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                    <p class="text-sm text-blue-100">&copy; 2026 <span class="font-semibold text-white">Student
                            Management System</span>. All rights reserved.</p>
                    <p class="text-sm text-blue-200">Students &middot; Courses &middot; Lecturers &middot; Registrations
                    </p>
                </div>
            </div>
        </footer>
        {{-- End: Footer --}}
    </div>
    {{-- End: Main content --}}

    <script>
    lucide.createIcons();
    </script>
</body>

</html>