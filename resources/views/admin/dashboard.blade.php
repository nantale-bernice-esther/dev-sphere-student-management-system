<!DOCTYPE html>
{{-- PAGE: Admin dashboard --}}
{{-- LARAVEL: view resources/views/dashboard/admin.blade.php  (one dashboard view PER role, no merging; the controller picks the right one) | route GET /dashboard (name: dashboard)  middleware: auth | controller DashboardControllerindex -> return view('dashboard.admin') when the user is an admin | data $studentCount, $courseCount, $registrationCount, $lecturerCount, $latestRegistrations --}}
{{-- TO CENTRALIZE THIS FILE: keep only the block 'Page content', wrap it in extends('layouts.app') section('content') ... endsection, delete everything else (it lives in the layout and partials) --}}
<html lang="en">
<head>
 {{-- Start: Head | CENTRALIZE: same on every page except the title -> layouts/app.blade.php (title becomes yield('title')) --}}
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Dashboard - Student Management System</title>
 <link rel="icon" type="image/svg+xml" href="../assets/img/logo.svg">
 <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 <script src="https://cdn.tailwindcss.com"></script>
 <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] } } } };</script>
 <link rel="stylesheet" href="../assets/css/styles.css">
 <script src="https://unpkg.com/lucide@latest"></script>
 <script src="../assets/js/app.js" defer></script>
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
 <label for="sidebar-toggle" class="inline-flex items-center p-2 text-slate-500 rounded-lg sm:hidden hover:bg-slate-100 cursor-pointer">
 <span class="sr-only">Open sidebar</span>
 <i data-lucide="menu" class="w-6 h-6"></i>
 </label>
 <a href="dashboard.html" class="flex items-center ms-2 md:me-8">
 <img src="../assets/img/logo.svg" alt="Student Management System" class="h-10 w-10 me-3">
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
 <aside class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 -translate-x-full peer-checked:translate-x-0 sm:translate-x-0 bg-white border-r border-slate-200 flex flex-col">
 <div class="flex-1 px-3 py-4 overflow-y-auto sidebar-scrollbar">
 {{-- Start: Sidebar group - Main --}}
 <div class="space-y-1 mb-5"><p class="px-3 text-xs font-semibold text-slate-400 uppercase mb-2">Main</p>
 {{-- Link: Dashboard | show with no permission (every role) | href route('dashboard') | active when request()->routeIs('dashboard') --}}
 <a href="dashboard.html" class="sidebar-item border-l-3 border-[#2563eb] bg-blue-50 text-[#2563eb] flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3"><i data-lucide="layout-dashboard" class="w-5 h-5 text-[#2563eb] transition-colors"></i><span class="ms-3 text-sm font-medium">Dashboard</span></a>
 </div>
 {{-- End: Sidebar group - Main --}}
 {{-- Start: Sidebar group - Manage --}}
 <div class="space-y-1 mb-5"><p class="px-3 text-xs font-semibold text-slate-400 uppercase mb-2">Manage</p>
 {{-- Link: Students | show with can('manage students') | href route('students.index') | active when request()->routeIs('students.*') --}}
 {{-- Open the students list where the administrator can view and manage student records. --}}
<a href="{{ route('administrator.students.index') }}" class="sidebar-item border-l-3 border-transparent text-slate-500 flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3">
    <i data-lucide="users" class="w-5 h-5 text-slate-400 group-hover:text-[#2563eb] transition-colors"></i>
    <span class="ms-3 text-sm font-medium">Students</span>
</a>
 {{-- Link: Courses | show with can('manage courses') | href route('courses.index') | active when request()->routeIs('courses.*') --}}
 <a href="{{ route('administrator.courses.index') }}" class="sidebar-item border-l-3 border-transparent text-slate-500 flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3"><i data-lucide="book-open" class="w-5 h-5 text-slate-400 group-hover:text-[#2563eb] transition-colors"></i><span class="ms-3 text-sm font-medium">Courses</span></a>
 {{-- Link: Registrations | show with can('manage registrations') | href route('registrations.index') | active when request()->routeIs('registrations.*') --}}
 <a href="registrations/index.html" class="sidebar-item border-l-3 border-transparent text-slate-500 flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3"><i data-lucide="clipboard-list" class="w-5 h-5 text-slate-400 group-hover:text-[#2563eb] transition-colors"></i><span class="ms-3 text-sm font-medium">Registrations</span></a>
 </div>
 {{-- End: Sidebar group - Manage --}}
 {{-- Start: Sidebar group - Access --}}
 <div class="space-y-1 mb-5"><p class="px-3 text-xs font-semibold text-slate-400 uppercase mb-2">Access</p>
 {{-- Link: User access | show with can('manage users') | href route('users.index') | active when request()->routeIs('users.*') --}}
 <a href="users/index.html" class="sidebar-item border-l-3 border-transparent text-slate-500 flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3"><i data-lucide="shield-check" class="w-5 h-5 text-slate-400 group-hover:text-[#2563eb] transition-colors"></i><span class="ms-3 text-sm font-medium">User access</span></a>
 </div>
 {{-- End: Sidebar group - Access --}}
 </div>
 {{-- Start: Sidebar user card | LARAVEL: same auth()->user() values as the header user menu --}}
 <div class="mt-auto border-t border-slate-200 p-4">
 <div class="flex items-center gap-3 mb-3">
 <div class="w-10 h-10 shrink-0 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[#2563eb] text-sm font-semibold">AU</div>
 <div class="min-w-0">
 <p class="text-sm font-semibold text-slate-900 truncate">Administrator</p>
 <p class="text-xs text-slate-500 truncate">administrator@gmail.com</p>
 </div>
 </div>
 <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-lg border border-slate-200">
 <i data-lucide="shield-check" class="w-4 h-4 text-[#2563eb]"></i>
 <span class="text-xs font-semibold text-slate-800 uppercase tracking-wide">Administrator</span>
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
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6"><div><h1 class="text-2xl font-bold text-slate-900">Welcome, Admin</h1><p class="text-slate-500 mt-1">Overview of students, courses and registrations.</p></div></div>
{{-- End: Page heading --}}

{{-- Start: Stats cards | numbers come from the controller --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 mb-8"><div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm"><div class="flex items-center gap-3"><div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center"><i data-lucide="users" class="w-5 h-5 text-[#2563eb]"></i></div><div><p class="text-2xl font-bold">5</p><p class="text-sm text-slate-500">Students</p></div></div></div><div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm"><div class="flex items-center gap-3"><div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center"><i data-lucide="book-open" class="w-5 h-5 text-[#d97706]"></i></div><div><p class="text-2xl font-bold">4</p><p class="text-sm text-slate-500">Courses</p></div></div></div><div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm"><div class="flex items-center gap-3"><div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center"><i data-lucide="clipboard-list" class="w-5 h-5 text-emerald-600"></i></div><div><p class="text-2xl font-bold">6</p><p class="text-sm text-slate-500">Registrations</p></div></div></div></div>
{{-- End: Stats cards --}}

{{-- Start: Latest registrations --}}
<h2 class="text-lg font-semibold mb-3">Latest registrations</h2>
{{-- Start: Table - recent | --}}
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm"><div class="overflow-x-auto"><table id="recent" class="w-full"><thead><tr class="border-b border-slate-200 bg-slate-50"><th class="py-3 px-4 text-left text-sm font-semibold text-slate-500">Student</th><th class="py-3 px-4 text-left text-sm font-semibold text-slate-500">Course</th><th class="py-3 px-4 text-left text-sm font-semibold text-slate-500">Registered on</th></tr></thead><tbody><tr class="border-b border-slate-200 hover:bg-slate-50"><td class="py-3 px-4 text-sm">Brian Ssemakula</td><td class="py-3 px-4 text-sm">BUC3131 — Advanced Web Application Development</td><td class="py-3 px-4 text-sm">03 Sep 2026</td></tr><tr class="border-b border-slate-200 hover:bg-slate-50"><td class="py-3 px-4 text-sm">Carol Auma</td><td class="py-3 px-4 text-sm">BUC3126 — Information Security and Auditing</td><td class="py-3 px-4 text-sm">03 Sep 2026</td></tr><tr class="border-b border-slate-200 hover:bg-slate-50"><td class="py-3 px-4 text-sm">David Kato</td><td class="py-3 px-4 text-sm">BUC3122 — Accounting Information Systems</td><td class="py-3 px-4 text-sm">04 Sep 2026</td></tr><tr class="border-b border-slate-200 hover:bg-slate-50"><td class="py-3 px-4 text-sm">Esther Nabirye</td><td class="py-3 px-4 text-sm">BUC3131 — Advanced Web Application Development</td><td class="py-3 px-4 text-sm">05 Sep 2026</td></tr></tbody></table></div></div>
{{-- End: Table - recent --}}

{{-- End: Latest registrations --}}

 {{-- End: Page content --}}

 </main>
 {{-- Start: Footer | CENTRALIZE: same on every page -> resources/views/partials/footer.blade.php, then include('partials.footer') --}}
 <footer class="bg-[#1e3a8a] mt-auto">
 <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
 <div class="flex flex-col md:flex-row justify-between items-center gap-3">
 <p class="text-sm text-blue-100">&copy; 2026 <span class="font-semibold text-white">Student Management System</span>. All rights reserved.</p>
 <p class="text-sm text-blue-200">Students &middot; Courses &middot; Lecturers &middot; Registrations</p>
 </div>
 </div>
 </footer>
 {{-- End: Footer --}}
 </div>
 {{-- End: Main content --}}

 <script>lucide.createIcons();</script>
</body>
</html>
