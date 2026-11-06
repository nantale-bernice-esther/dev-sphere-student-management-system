<!DOCTYPE html>
{{-- PAGE: Edit student (admin) --}}
{{-- LARAVEL: view resources/views/students/edit.blade.php  (@include the same students/_form.blade.php) | route GET /students/{student}/edit (students.edit);  form posts PUT /students/{student} (students.update) | controller StudentController@edit and @update | data $student --}}
{{-- TO CENTRALIZE THIS FILE: keep only the block 'Page content', wrap it in @extends('layouts.app') @section('content') ... @endsection, delete everything else (it lives in the layout and partials) --}}
<html lang="en">

<head>
    {{-- Start: Head | CENTRALIZE: same on every page except the title -> layouts/app.blade.php (title becomes @yield('title')) --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit student - Student Management System</title>
    <link rel="icon" type="image/svg+xml" href="../../assets/img/logo.svg">
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
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="../../assets/js/app.js" defer></script>
    {{-- End: Head --}}
</head>

<body class="bg-white text-slate-900 font-sans antialiased min-h-screen">
    {{-- Start: Sidebar toggle (checkbox, no JavaScript) | CENTRALIZE: same on every page -> layouts/app.blade.php --}}
    <input type="checkbox" id="sidebar-toggle" class="peer hidden">
    <label for="sidebar-toggle" class="fixed inset-0 bg-slate-900/30 z-30 hidden peer-checked:block sm:!hidden"></label>
    {{-- End: Sidebar toggle --}}

    {{-- Start: Header | CENTRALIZE: same on every page -> resources/views/partials/header.blade.php, then @include('partials.header') --}}
    <header class="fixed top-0 z-50 w-full bg-white border-b border-slate-200">
        <div class="px-2 py-2 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <label for="sidebar-toggle"
                        class="inline-flex items-center p-2 text-slate-500 rounded-lg sm:hidden hover:bg-slate-100 cursor-pointer">
                        <span class="sr-only">Open sidebar</span>
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </label>
                    <a href="../dashboard.html" class="flex items-center ms-2 md:me-8">
                        <img src="../../assets/img/logo.svg" alt="Student Management System" class="h-10 w-10 me-3">
                        <div class="flex flex-col">
                            <span class="font-semibold text-slate-900 text-base">Student Management System</span>
                            <span class="text-xs text-slate-500">Makerere University Business School</span>
                        </div>
                    </a>
                </div>
                {{-- Start: Header user menu | LARAVEL: name = {{ auth()->user()->name }}, email =
                {{ auth()->user()->email }}, role = {{ auth()->user()->getRoleNames()->first() }} --}}
                <details class="menu-dropdown relative">
                    <summary
                        class="flex items-center gap-2 bg-slate-50 rounded-lg p-1 text-sm border border-slate-200 hover:bg-slate-100 cursor-pointer list-none">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-[#2563eb] border border-blue-100 text-xs font-semibold">
                            AU</div>
                        <div class="hidden md:block text-left mr-1">
                            <div class="text-xs font-medium text-slate-900">Admin User</div>
                            <div class="text-[10px] text-slate-500">Administrator</div>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                    </summary>
                    <div class="absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-lg shadow-lg z-50">
                        <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
                            <p class="text-sm font-medium">Admin User</p>
                            <p class="text-xs text-slate-500 truncate">admin@mubs.ac.ug</p>
                        </div>
                        {{-- LARAVEL: Sign out must be a POST form: <form method="POST" action="{{ route('logout') }}">
                        @csrf <button>Sign out</button> </form> --}}
                        <a href="../../login.html"
                            class="flex items-center px-4 py-2 text-sm text-[#d97706] hover:bg-slate-50"><i
                                data-lucide="log-out" class="w-4 h-4 mr-2"></i>Sign out</a>
                    </div>
                </details>
                {{-- End: Header user menu --}}
            </div>
        </div>
    </header>
    {{-- End: Header --}}

    {{-- Start: Sidebar | THIS prototype shows only the links for this role. In Laravel keep ONE sidebar file with ALL links (see _reference/sidebar-all-links.html); @can hides the links this user may not use -> resources/views/partials/sidebar.blade.php --}}
    <aside
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 -translate-x-full peer-checked:translate-x-0 sm:translate-x-0 bg-white border-r border-slate-200 flex flex-col">
        <div class="flex-1 px-3 py-4 overflow-y-auto sidebar-scrollbar">
            {{-- Start: Sidebar group - Main --}}
            <div class="space-y-1 mb-5">
                <p class="px-3 text-xs font-semibold text-slate-400 uppercase mb-2">Main</p>
                {{-- Link: Dashboard | show with no permission (every role) | href route('dashboard') | active when request()->routeIs('dashboard') --}}
                <a href="../dashboard.html"
                    class="sidebar-item border-l-3 border-transparent text-slate-500 flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3"><i
                        data-lucide="layout-dashboard"
                        class="w-5 h-5 text-slate-400 group-hover:text-[#2563eb] transition-colors"></i><span
                        class="ms-3 text-sm font-medium">Dashboard</span></a>
            </div>
            {{-- End: Sidebar group - Main --}}
            {{-- Start: Sidebar group - Manage --}}
            <div class="space-y-1 mb-5">
                <p class="px-3 text-xs font-semibold text-slate-400 uppercase mb-2">Manage</p>
                {{-- Link: Students | show with @can('manage students') | href route('students.index') | active when request()->routeIs('students.*') --}}
                <a href="{{ route('administrator.students.index') }}"
                    class="sidebar-item border-l-3 border-[#2563eb] bg-blue-50 text-[#2563eb] flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3"><i
                        data-lucide="users" class="w-5 h-5 text-[#2563eb] transition-colors"></i><span
                        class="ms-3 text-sm font-medium">Students</span></a>
                {{-- Link: Courses | show with @can('manage courses') | href route('courses.index') | active when request()->routeIs('courses.*') --}}
                <a href="../courses/index.html"
                    class="sidebar-item border-l-3 border-transparent text-slate-500 flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3"><i
                        data-lucide="book-open"
                        class="w-5 h-5 text-slate-400 group-hover:text-[#2563eb] transition-colors"></i><span
                        class="ms-3 text-sm font-medium">Courses</span></a>
                {{-- Link: Registrations | show with @can('manage registrations') | href route('registrations.index') | active when request()->routeIs('registrations.*') --}}
                <a href="../registrations/index.html"
                    class="sidebar-item border-l-3 border-transparent text-slate-500 flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3"><i
                        data-lucide="clipboard-list"
                        class="w-5 h-5 text-slate-400 group-hover:text-[#2563eb] transition-colors"></i><span
                        class="ms-3 text-sm font-medium">Registrations</span></a>
            </div>
            {{-- End: Sidebar group - Manage --}}
            {{-- Start: Sidebar group - Access --}}
            <div class="space-y-1 mb-5">
                <p class="px-3 text-xs font-semibold text-slate-400 uppercase mb-2">Access</p>
                {{-- Link: User access | show with @can('manage users') | href route('users.index') | active when request()->routeIs('users.*') --}}
                <a href="../users/index.html"
                    class="sidebar-item border-l-3 border-transparent text-slate-500 flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3"><i
                        data-lucide="shield-check"
                        class="w-5 h-5 text-slate-400 group-hover:text-[#2563eb] transition-colors"></i><span
                        class="ms-3 text-sm font-medium">User access</span></a>
            </div>
            {{-- End: Sidebar group - Access --}}
        </div>
        {{-- Start: Sidebar user card | LARAVEL: same auth()->user() values as the header user menu --}}
        <div class="mt-auto border-t border-slate-200 p-4">
            <div class="flex items-center gap-3 mb-3">
                <div
                    class="w-10 h-10 shrink-0 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[#2563eb] text-sm font-semibold">
                    AU</div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-900 truncate">Admin User</p>
                    <p class="text-xs text-slate-500 truncate">admin@mubs.ac.ug</p>
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

            {{-- Start: Flash messages | PROTOTYPE: empty on page load; assets/js/app.js fills it when you click Save, Delete or Register, and it is gone after a reload. CENTRALIZE: partials/flash.blade.php. LARAVEL: the controller sets ->with('success', '...') and the partial prints it with @if(session('success')) ... @endif --}}
            <div id="flash-messages" class="mb-4 space-y-2"></div>
            {{-- End: Flash messages --}}

            {{-- Start: Page content | UNIQUE on every page -> stays in this page's own file (@section('content')); in the layout it is just @yield('content') --}}

            {{-- Start: Page heading | main button: wrap in @can('manage ...') --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Edit student</h1>
                    {{-- Show the problems if the form data was not valid. --}}
@if ($errors->any())
    <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-700">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                </div>
            </div>
            {{-- End: Page heading --}}

            {{-- Start: Form | PROTOTYPE: assets/js/app.js checks the required fields and shows the success or error message when you click the button. LARAVEL: action="{{ route('x.store') }}"
            method="POST" + @csrf (edit page: route('x.update', $item) + @method('PUT')); create and edit share the
            fields -> _form.blade.php --}}
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm max-w-3xl">
                <form action="{{ route('administrator.students.update', $student->id) }}" method="POST"
                    data-success="Student updated successfully." novalidate>
                    {{-- @csrf is Laravel's security token. Every form must have it,
     or Laravel refuses the form with "Page Expired". --}}
@csrf

{{-- A form can only send GET or POST. This hidden field tells Laravel
     to treat this form as an update (PUT). --}}
@method('PUT')
                    {{-- Start: Form fields | each value: value="{{ old('field', $item->field ?? '') }}" and under each
                    input: @error('field') {{ $message }} @enderror --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div><label for="student_number" class="block text-sm font-medium mb-1">Student
                                number</label><input id="student_number" name="student_number" type="text"
                                value="{{ old('student_number', $student->student_number) }}" placeholder=""
                                data-required class="input-field"></div>
                        <div><label for="name" class="block text-sm font-medium mb-1">Full name</label><input id="name"
                                name="name" type="text" value="{{ old('name', $student->user->name) }}" placeholder=""
                                data-required class="input-field"></div>
                        <div><label for="email" class="block text-sm font-medium mb-1">Email</label><input id="email"
                                name="email" type="email" value="{{ old('email', $student->user->email) }}"
                                placeholder="" data-required class="input-field"></div>
                        <div><label for="programme" class="block text-sm font-medium mb-1">Programme</label><select
                                id="programme" name="programme" data-required class="input-field">
                                <option value="">Select...</option>
                                <option value="Business Computing"
                                    {{ old('programme', $student->programme) == 'Business Computing' ? 'selected' : '' }}>
                                    Business Computing</option>
                                <option value="Information Systems"
                                    {{ old('programme', $student->programme) == 'Information Systems' ? 'selected' : '' }}>
                                    Information Systems</option>
                            </select></div>
                        <div><label for="year_of_study" class="block text-sm font-medium mb-1">Year of
                                study</label><select id="year_of_study" name="year_of_study" data-required
                                class="input-field">
                                <option value="">Select...</option>
                                <option value="1"
                                    {{ old('year_of_study', $student->year_of_study) == 1 ? 'selected' : '' }}>Year 1
                                </option>
                                <option value="2"
                                    {{ old('year_of_study', $student->year_of_study) == 2 ? 'selected' : '' }}>Year 2
                                </option>
                                <option value="3" selected>Year 3</option>
                                <option value="4">Year 4</option>
                            </select></div>
                    </div>
                    {{-- End: Form fields --}}
                    {{-- Start: Form buttons --}}
                    <div class="mt-6 flex items-center gap-3"><button type="submit"
                            class="px-4 py-2 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8]">Update</button><a
                            href="{{ route('administrator.students.index') }}"
                            class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 border border-slate-200 hover:bg-slate-50">Cancel</a>
                    </div>
                    {{-- End: Form buttons --}}
                </form>
            </div>
            {{-- End: Form --}}

            {{-- End: Page content --}}

        </main>
        {{-- Start: Footer | CENTRALIZE: same on every page -> resources/views/partials/footer.blade.php, then @include('partials.footer') --}}
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