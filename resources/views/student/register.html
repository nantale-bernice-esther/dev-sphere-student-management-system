<!DOCTYPE html>
<!-- PAGE: Register for a course (student) -->
<!-- LARAVEL: view resources/views/student/register.blade.php | route GET /student/courses/{course}/register (student.register.create);  POST /student/courses/{course}/register (student.register.store)  middleware: permission:register courses | controller StudentCourseController@create and @store | data $course. store: the student comes from auth()->user() (never from the form); validate with Rule::unique on the pair; flash the success or error message -->
<!-- TO CENTRALIZE THIS FILE: keep only the block 'Page content', wrap it in @extends('layouts.app') @section('content') ... @endsection, delete everything else (it lives in the layout and partials) -->
<html lang="en">
<head>
 <!-- Start: Head | CENTRALIZE: same on every page except the title -> layouts/app.blade.php (title becomes @yield('title')) -->
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Register for a course - Student Management System</title>
 <link rel="icon" type="image/svg+xml" href="../assets/img/logo.svg">
 <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 <script src="https://cdn.tailwindcss.com"></script>
 <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] } } } };</script>
 <link rel="stylesheet" href="../assets/css/styles.css">
 <script src="https://unpkg.com/lucide@latest"></script>
 <script src="../assets/js/app.js" defer></script>
 <!-- End: Head -->
</head>
<body class="bg-white text-slate-900 font-sans antialiased min-h-screen">
 <!-- Start: Sidebar toggle (checkbox, no JavaScript) | CENTRALIZE: same on every page -> layouts/app.blade.php -->
 <input type="checkbox" id="sidebar-toggle" class="peer hidden">
 <label for="sidebar-toggle" class="fixed inset-0 bg-slate-900/30 z-30 hidden peer-checked:block sm:!hidden"></label>
 <!-- End: Sidebar toggle -->

 <!-- Start: Header | CENTRALIZE: same on every page -> resources/views/partials/header.blade.php, then @include('partials.header') -->
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
 <!-- Start: Header user menu | LARAVEL: name = {{ auth()->user()->name }}, email = {{ auth()->user()->email }}, role = {{ auth()->user()->getRoleNames()->first() }} -->
 <details class="menu-dropdown relative">
 <summary class="flex items-center gap-2 bg-slate-50 rounded-lg p-1 text-sm border border-slate-200 hover:bg-slate-100 cursor-pointer list-none">
 <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-[#2563eb] border border-blue-100 text-xs font-semibold">AN</div>
 <div class="hidden md:block text-left mr-1">
 <div class="text-xs font-medium text-slate-900">Aisha Namuli</div>
 <div class="text-[10px] text-slate-500">Student</div>
 </div>
 <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
 </summary>
 <div class="absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-lg shadow-lg z-50">
 <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
 <p class="text-sm font-medium">Aisha Namuli</p>
 <p class="text-xs text-slate-500 truncate">aisha.namuli@mubs.ac.ug</p>
 </div>
 <!-- LARAVEL: Sign out must be a POST form: <form method="POST" action="{{ route('logout') }}"> @csrf <button>Sign out</button> </form> -->
 <a href="../login.html" class="flex items-center px-4 py-2 text-sm text-[#d97706] hover:bg-slate-50"><i data-lucide="log-out" class="w-4 h-4 mr-2"></i>Sign out</a>
 </div>
 </details>
 <!-- End: Header user menu -->
 </div>
 </div>
 </header>
 <!-- End: Header -->

 <!-- Start: Sidebar | THIS prototype shows only the links for this role. In Laravel keep ONE sidebar file with ALL links (see _reference/sidebar-all-links.html); @can hides the links this user may not use -> resources/views/partials/sidebar.blade.php -->
 <aside class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 -translate-x-full peer-checked:translate-x-0 sm:translate-x-0 bg-white border-r border-slate-200 flex flex-col">
 <div class="flex-1 px-3 py-4 overflow-y-auto sidebar-scrollbar">
 <!-- Start: Sidebar group - Main -->
 <div class="space-y-1 mb-5"><p class="px-3 text-xs font-semibold text-slate-400 uppercase mb-2">Main</p>
 <!-- Link: Dashboard | show with no permission (every role) | href route('dashboard') | active when request()->routeIs('dashboard') -->
 <a href="dashboard.html" class="sidebar-item border-l-3 border-transparent text-slate-500 flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3"><i data-lucide="layout-dashboard" class="w-5 h-5 text-slate-400 group-hover:text-[#2563eb] transition-colors"></i><span class="ms-3 text-sm font-medium">Dashboard</span></a>
 </div>
 <!-- End: Sidebar group - Main -->
 <!-- Start: Sidebar group - Courses -->
 <div class="space-y-1 mb-5"><p class="px-3 text-xs font-semibold text-slate-400 uppercase mb-2">Courses</p>
 <!-- Link: Available courses | show with @can('view available courses') | href route('student.courses') | active when request()->routeIs('student.courses*') -->
 <a href="courses.html" class="sidebar-item border-l-3 border-[#2563eb] bg-blue-50 text-[#2563eb] flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3"><i data-lucide="book-open" class="w-5 h-5 text-[#2563eb] transition-colors"></i><span class="ms-3 text-sm font-medium">Available courses</span></a>
 <!-- Link: My registrations | show with @can('view own registrations') | href route('student.registrations') | active when request()->routeIs('student.registrations') -->
 <a href="registrations.html" class="sidebar-item border-l-3 border-transparent text-slate-500 flex items-center p-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 group text-sm transition-all duration-200 pl-3"><i data-lucide="clipboard-check" class="w-5 h-5 text-slate-400 group-hover:text-[#2563eb] transition-colors"></i><span class="ms-3 text-sm font-medium">My registrations</span></a>
 </div>
 <!-- End: Sidebar group - Courses -->
 </div>
 <!-- Start: Sidebar user card | LARAVEL: same auth()->user() values as the header user menu -->
 <div class="mt-auto border-t border-slate-200 p-4">
 <div class="flex items-center gap-3 mb-3">
 <div class="w-10 h-10 shrink-0 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[#2563eb] text-sm font-semibold">AN</div>
 <div class="min-w-0">
 <p class="text-sm font-semibold text-slate-900 truncate">Aisha Namuli</p>
 <p class="text-xs text-slate-500 truncate">aisha.namuli@mubs.ac.ug</p>
 </div>
 </div>
 <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-lg border border-slate-200">
 <i data-lucide="graduation-cap" class="w-4 h-4 text-[#2563eb]"></i>
 <span class="text-xs font-semibold text-slate-800 uppercase tracking-wide">Student</span>
 </div>
 </div>
 <!-- End: Sidebar user card -->
 </aside>
 <!-- End: Sidebar -->

 <!-- Start: Main content | CENTRALIZE: this wrapper stays in layouts/app.blade.php -->
 <div class="pt-16 sm:pl-64 min-h-screen flex flex-col">
 <main class="flex-1 pb-8 px-4 sm:px-8 lg:px-10 pt-6">

 <!-- Start: Flash messages | PROTOTYPE: empty on page load; assets/js/app.js fills it when you click Save, Delete or Register, and it is gone after a reload. CENTRALIZE: partials/flash.blade.php. LARAVEL: the controller sets ->with('success', '...') and the partial prints it with @if(session('success')) ... @endif -->
 <div id="flash-messages" class="mb-4 space-y-2"></div>
 <!-- End: Flash messages -->

 <!-- Start: Page content | UNIQUE on every page -> stays in this page's own file (@section('content')); in the layout it is just @yield('content') -->

<!-- Start: Page heading | main button: wrap in @can('manage ...') -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6"><div><h1 class="text-2xl font-bold text-slate-900">Register for a course</h1><p class="text-slate-500 mt-1">Check the course details, choose the semester and confirm.</p></div></div>
<!-- End: Page heading -->

<!-- Start: Course summary | LARAVEL: print $course->code, $course->title, $course->credit_units, $course->lecturer->name -->
<div id="course-summary" class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm mb-6 max-w-3xl"><dl class="grid grid-cols-1 sm:grid-cols-2 gap-5"><div><dt class="text-xs font-semibold text-slate-400 uppercase">Course code</dt><dd id="course-code" class="text-sm text-slate-900 mt-1"></dd></div><div><dt class="text-xs font-semibold text-slate-400 uppercase">Title</dt><dd id="course-title" class="text-sm text-slate-900 mt-1"></dd></div><div><dt class="text-xs font-semibold text-slate-400 uppercase">Credit units</dt><dd id="course-credits" class="text-sm text-slate-900 mt-1"></dd></div><div><dt class="text-xs font-semibold text-slate-400 uppercase">Lecturer</dt><dd id="course-lecturer" class="text-sm text-slate-900 mt-1"></dd></div></dl></div>
<!-- End: Course summary -->

<!-- Start: Form | PROTOTYPE: assets/js/app.js checks the required fields and shows the success or error message when you click the button. LARAVEL: action="{{ route('x.store') }}" method="POST" + @csrf (edit page: route('x.update', $item) + @method('PUT')); create and edit share the fields -> _form.blade.php -->
<div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm max-w-3xl"><form action="#" method="POST" data-success="You are now registered for {course}." id="register-form" data-lock-after data-dup-courses="0,2" data-dup-message="You are already registered for this course." novalidate>
<!-- Start: Form fields | each value: value="{{ old('field', $item->field ?? '') }}" and under each input: @error('field') {{ $message }} @enderror -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-5"><input type="hidden" id="course-id" name="course_id" value=""><div><label for="semester" class="block text-sm font-medium mb-1">Semester</label><select id="semester" name="semester" data-required class="input-field"><option value="">Select...</option><option value="Semester I 2026/27">Semester I 2026/27</option></select></div></div>
<!-- End: Form fields -->
<!-- Start: Form buttons -->
<div class="mt-6 flex items-center gap-3"><button type="submit" class="px-4 py-2 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8]">Confirm registration</button><a href="courses.html" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 border border-slate-200 hover:bg-slate-50">Cancel</a></div>
<!-- End: Form buttons -->
</form></div>
<!-- End: Form -->

<!-- Start: Prototype script | PROTOTYPE ONLY: reads ?course=0 from the address and fills the summary. LARAVEL: delete this; the controller passes $course and the Blade prints it -->
<script>
(function () {
  var courses = [{code:"BUC3131",title:"Advanced Web Application Development",credits:"4",lecturer:"Dr. Sarah Nakato"},{code:"BUC3126",title:"Information Security and Auditing",credits:"4",lecturer:"Mr. Peter Okello"},{code:"BUC3133",title:"Mobile Application Development",credits:"4",lecturer:"Dr. Sarah Nakato"},{code:"BUC3122",title:"Accounting Information Systems",credits:"4",lecturer:"Mr. Peter Okello"}];
  var i = new URLSearchParams(location.search).get('course');
  var c = courses[i];
  var summary = document.getElementById('course-summary');
  var form = document.getElementById('register-form');
  if (!c) {
    summary.innerHTML = '<p class="text-sm text-slate-600">No course selected. Go to <a class="text-[#2563eb] underline" href="courses.html">Available courses</a> and press Register on a course.</p>';
    form.style.display = 'none';
    return;
  }
  document.getElementById('course-code').textContent = c.code;
  document.getElementById('course-title').textContent = c.title;
  document.getElementById('course-credits').textContent = c.credits;
  document.getElementById('course-lecturer').textContent = c.lecturer;
  document.getElementById('course-id').value = i;
})();
</script>
<!-- End: Prototype script -->

 <!-- End: Page content -->

 </main>
 <!-- Start: Footer | CENTRALIZE: same on every page -> resources/views/partials/footer.blade.php, then @include('partials.footer') -->
 <footer class="bg-[#1e3a8a] mt-auto">
 <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
 <div class="flex flex-col md:flex-row justify-between items-center gap-3">
 <p class="text-sm text-blue-100">&copy; 2026 <span class="font-semibold text-white">Student Management System</span>. All rights reserved.</p>
 <p class="text-sm text-blue-200">Students &middot; Courses &middot; Lecturers &middot; Registrations</p>
 </div>
 </div>
 </footer>
 <!-- End: Footer -->
 </div>
 <!-- End: Main content -->

 <script>lucide.createIcons();</script>
</body>
</html>
