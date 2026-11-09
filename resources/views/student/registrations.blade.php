<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My registrations - Student Management System</title>

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
</head>

<body class="bg-white text-slate-900 font-sans antialiased min-h-screen">

    <input type="checkbox" id="sidebar-toggle" class="peer hidden">

    <label for="sidebar-toggle" class="fixed inset-0 bg-slate-900/30 z-30 hidden peer-checked:block sm:!hidden"></label>

    <header class="fixed top-0 z-50 w-full bg-white border-b border-slate-200">

        <div class="px-2 py-2 lg:px-5 lg:pl-3">

            <div class="flex items-center justify-between">

                <div class="flex items-center">

                    <label for="sidebar-toggle" class="inline-flex items-center p-2 text-slate-500 rounded-lg sm:hidden hover:bg-slate-100 cursor-pointer">
                        <span class="sr-only">Open sidebar</span>
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </label>

                    <a href="{{ route('student.dashboard') }}" class="flex items-center ms-2 md:me-8">

                        <img src="{{ asset('assets/img/logo.svg') }}" alt="Student Management System" class="h-10 w-10 me-3">

                        <div class="flex flex-col">
                            <span class="font-semibold text-slate-900 text-base">Student Management System</span>
                            <span class="text-xs text-slate-500">Makerere University Business School</span>
                        </div>

                    </a>

                </div>

                <details class="menu-dropdown relative">

                    <summary class="flex items-center gap-2 bg-slate-50 rounded-lg p-1 text-sm border border-slate-200 hover:bg-slate-100 cursor-pointer list-none">

                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-[#2563eb] border border-blue-100 text-xs font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>

                        <div class="hidden md:block text-left mr-1">

                            <div class="text-xs font-medium text-slate-900">
                                {{ auth()->user()->name }}
                            </div>

                            <div class="text-[10px] text-slate-500">Student</div>

                        </div>

                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>

                    </summary>

                    <div class="absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-lg shadow-lg z-50">

                        <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">

                            <p class="text-sm font-medium">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs text-slate-500 truncate">
                                {{ auth()->user()->email }}
                            </p>

                        </div>

                        <form method="POST" action="{{ route('logout') }}">

                            @csrf

                            <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-[#d97706] hover:bg-slate-50">
                                <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
                                Sign out
                            </button>

                        </form>

                    </div>

                </details>

            </div>

        </div>

    </header>

    <aside class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 -translate-x-full peer-checked:translate-x-0 sm:translate-x-0 bg-white border-r border-slate-200 flex flex-col">

        <div class="flex-1 px-3 py-4 overflow-y-auto sidebar-scrollbar">

            <div class="space-y-1 mb-5">

                <p class="px-3 text-xs font-semibold text-slate-400 uppercase mb-2">
                    Main
                </p>

                <a href="{{ route('student.dashboard') }}" class="sidebar-item border-l-3 border-transparent text-slate-500 flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3">

                    <i data-lucide="layout-dashboard" class="w-5 h-5 text-slate-400 group-hover:text-[#2563eb] transition-colors"></i>

                    <span class="ms-3 text-sm font-medium">Dashboard</span>

                </a>

            </div>

            <div class="space-y-1 mb-5">

                <p class="px-3 text-xs font-semibold text-slate-400 uppercase mb-2">
                    Courses
                </p>

                <a href="{{ route('student.courses') }}" class="sidebar-item border-l-3 border-transparent text-slate-500 flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3">

                    <i data-lucide="book-open" class="w-5 h-5 text-slate-400 group-hover:text-[#2563eb] transition-colors"></i>

                    <span class="ms-3 text-sm font-medium">Available courses</span>

                </a>

                <a href="{{ route('student.registrations') }}" class="sidebar-item border-l-3 border-[#2563eb] bg-blue-50 text-[#2563eb] flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3">

                    <i data-lucide="clipboard-check" class="w-5 h-5 text-[#2563eb] transition-colors"></i>

                    <span class="ms-3 text-sm font-medium">My registrations</span>

                </a>

            </div>

        </div>

        <div class="mt-auto border-t border-slate-200 p-4">

            <div class="flex items-center gap-3 mb-3">

                <div class="w-10 h-10 shrink-0 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[#2563eb] text-sm font-semibold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>

                <div class="min-w-0">

                    <p class="text-sm font-semibold text-slate-900 truncate">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-slate-500 truncate">
                        {{ auth()->user()->email }}
                    </p>

                </div>

            </div>

            <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-lg border border-slate-200">

                <i data-lucide="graduation-cap" class="w-4 h-4 text-[#2563eb]"></i>

                <span class="text-xs font-semibold text-slate-800 uppercase tracking-wide">
                    Student
                </span>

            </div>

        </div>

    </aside>

    <div class="pt-16 sm:pl-64 min-h-screen flex flex-col">

        <main class="flex-1 pb-8 px-4 sm:px-8 lg:px-10 pt-6">

            <div id="flash-messages" class="mb-4 space-y-2">

                @if(session('success'))

                    <div class="p-3 rounded-lg bg-emerald-50 text-emerald-700 text-sm">
                        {{ session('success') }}
                    </div>

                @endif

                @if(session('error'))

                    <div class="p-3 rounded-lg bg-red-50 text-red-700 text-sm">
                        {{ session('error') }}
                    </div>

                @endif

            </div>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">

                <div>

                    <h1 class="text-2xl font-bold text-slate-900">
                        My registrations
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Only your own records are shown here.
                    </p>

                </div>

            </div>

            <div class="mb-4 max-w-sm">

                <input
                    type="search"
                    class="input-field"
                    placeholder="Search..."
                    data-filter="#my"
                >

            </div>

            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">

                <div class="overflow-x-auto">

                    <table id="my" class="w-full">

                        <thead>

                            <tr class="border-b border-slate-200 bg-slate-50">

                                <th class="py-3 px-4 text-left text-sm font-semibold text-slate-500">
                                    Code
                                </th>

                                <th class="py-3 px-4 text-left text-sm font-semibold text-slate-500">
                                    Title
                                </th>

                                <th class="py-3 px-4 text-left text-sm font-semibold text-slate-500">
                                    Lecturer
                                </th>

                                <th class="py-3 px-4 text-left text-sm font-semibold text-slate-500">
                                    Semester
                                </th>

                                <th class="py-3 px-4 text-left text-sm font-semibold text-slate-500">
                                    Registered on
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($registrations as $registration)

                                <tr class="border-b border-slate-200 hover:bg-slate-50">

                                    <td class="py-3 px-4 text-sm">
                                        {{ $registration->course->code ?? 'N/A' }}
                                    </td>

                                    <td class="py-3 px-4 text-sm">
                                        {{ $registration->course->title ?? 'Course unavailable' }}
                                    </td>

                                    <td class="py-3 px-4 text-sm">

                                        <span class="text-slate-500">
                                            {{ $registration->course->lecturer->name ?? 'Not assigned' }}
                                        </span>

                                    </td>

                                    <td class="py-3 px-4 text-sm">
                                        {{ $registration->semester }}
                                    </td>

                                    <td class="py-3 px-4 text-sm">
                                        {{ $registration->created_at?->format('d M Y') ?? 'N/A' }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="py-8 px-4 text-center text-slate-500">

                                        <i data-lucide="clipboard-list" class="w-8 h-8 mx-auto mb-3 text-slate-400"></i>

                                        <p>
                                            You have not registered for any courses yet.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="p-4">
                    {{ $registrations->links() }}
                </div>

            </div>

        </main>

        <footer class="bg-[#1e3a8a] mt-auto">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">

                <div class="flex flex-col md:flex-row justify-between items-center gap-3">

                    <p class="text-sm text-blue-100">
                        &copy; 2026
                        <span class="font-semibold text-white">Student Management System</span>.
                        All rights reserved.
                    </p>

                    <p class="text-sm text-blue-200">
                        Students &middot; Courses &middot; Lecturers &middot; Registrations
                    </p>

                </div>

            </div>

        </footer>

    </div>

    <script>
        lucide.createIcons();
    </script>

</body>
</html>