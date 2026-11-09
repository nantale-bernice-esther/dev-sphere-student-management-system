{{-- resources/views/partials/sidebar.blade.php --}}
<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 -translate-x-full peer-checked:translate-x-0 sm:translate-x-0 bg-white border-r border-slate-200 flex flex-col transition-transform duration-200 ease-in-out">
    <div class="flex-1 px-3 py-4 overflow-y-auto sidebar-scrollbar space-y-6">

        <!-- Main Section -->
        <div>
            <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Main</p>
            <div class="space-y-1">
                @php
                    $isDashboard = request()->routeIs('home') || request()->routeIs('*.dashboard');
                @endphp
                <a href="{{ route('home') }}"
                   class="sidebar-item border-l-3 {{ $isDashboard ? 'border-[#2563eb] bg-blue-50 text-[#2563eb]' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center p-2 rounded-lg group text-sm font-medium transition-colors duration-150 pl-3">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 {{ $isDashboard ? 'text-[#2563eb]' : 'text-slate-400 group-hover:text-[#2563eb]' }} transition-colors"></i>
                    <span class="ms-3">Dashboard</span>
                </a>
            </div>
        </div>

        <!-- Management Section (Guarded by permissions / role) -->
        @if (auth()->check() && (auth()->user()->can('manage student') || auth()->user()->can('manage courses') || auth()->user()->can('manage registrations') || auth()->user()->hasRole('administrator')))
            <div>
                <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Manage</p>
                <div class="space-y-1">
                    @if (auth()->user()->can('manage student') || auth()->user()->hasRole('administrator'))
                        @php $isStudents = request()->routeIs('students.*'); @endphp
                        <a href="{{ route('students.index') }}"
                           class="sidebar-item border-l-3 {{ $isStudents ? 'border-[#2563eb] bg-blue-50 text-[#2563eb]' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center p-2 rounded-lg group text-sm font-medium transition-colors duration-150 pl-3">
                            <i data-lucide="users" class="w-5 h-5 {{ $isStudents ? 'text-[#2563eb]' : 'text-slate-400 group-hover:text-[#2563eb]' }} transition-colors"></i>
                            <span class="ms-3">Students</span>
                        </a>
                    @endif

                    @if (auth()->user()->can('manage courses') || auth()->user()->hasRole('administrator'))
                        @php $isCourses = request()->routeIs('courses.*'); @endphp
                        <a href="{{ route('courses.index') }}"
                           class="sidebar-item border-l-3 {{ $isCourses ? 'border-[#2563eb] bg-blue-50 text-[#2563eb]' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center p-2 rounded-lg group text-sm font-medium transition-colors duration-150 pl-3">
                            <i data-lucide="book-open" class="w-5 h-5 {{ $isCourses ? 'text-[#2563eb]' : 'text-slate-400 group-hover:text-[#2563eb]' }} transition-colors"></i>
                            <span class="ms-3">Courses</span>
                        </a>
                    @endif

                    @if (auth()->user()->can('manage registrations') || auth()->user()->hasRole('administrator'))
                        @php $isRegistrations = request()->routeIs('registrations.*'); @endphp
                        <a href="{{ route('registrations.index') }}"
                           class="sidebar-item border-l-3 {{ $isRegistrations ? 'border-[#2563eb] bg-blue-50 text-[#2563eb]' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center p-2 rounded-lg group text-sm font-medium transition-colors duration-150 pl-3">
                            <i data-lucide="clipboard-list" class="w-5 h-5 {{ $isRegistrations ? 'text-[#2563eb]' : 'text-slate-400 group-hover:text-[#2563eb]' }} transition-colors"></i>
                            <span class="ms-3">Registrations</span>
                        </a>
                    @endif

                    @if (auth()->user()->can('manage lecturers') || auth()->user()->hasRole('administrator'))
                        @php $isLecturers = request()->routeIs('lecturers.*'); @endphp
                        <a href="{{ route('lecturers.index') }}"
                           class="sidebar-item border-l-3 {{ $isLecturers ? 'border-[#2563eb] bg-blue-50 text-[#2563eb]' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center p-2 rounded-lg group text-sm font-medium transition-colors duration-150 pl-3">
                            <i data-lucide="user-check" class="w-5 h-5 {{ $isLecturers ? 'text-[#2563eb]' : 'text-slate-400 group-hover:text-[#2563eb]' }} transition-colors"></i>
                            <span class="ms-3">Lecturers</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif

        <!-- Access Section (Guarded by permissions / role) -->
        @if (auth()->check() && (auth()->user()->can('manage roles') || auth()->user()->can('manage users') || auth()->user()->hasRole('administrator')))
            <div>
                <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Access</p>
                <div class="space-y-1">
                    @if (auth()->user()->can('manage roles') || auth()->user()->hasRole('administrator'))
                        @php $isRoles = request()->routeIs('roles.*'); @endphp
                        <a href="{{ route('roles.index') }}"
                           class="sidebar-item border-l-3 {{ $isRoles ? 'border-[#2563eb] bg-blue-50 text-[#2563eb]' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center p-2 rounded-lg group text-sm font-medium transition-colors duration-150 pl-3">
                            <i data-lucide="key" class="w-5 h-5 {{ $isRoles ? 'text-[#2563eb]' : 'text-slate-400 group-hover:text-[#2563eb]' }} transition-colors"></i>
                            <span class="ms-3">Roles &amp; permissions</span>
                        </a>
                    @endif

                    @if (auth()->user()->can('manage users') || auth()->user()->hasRole('administrator'))
                        @php $isUsers = request()->routeIs('users.*'); @endphp
                        <a href="{{ route('users.index') }}"
                           class="sidebar-item border-l-3 {{ $isUsers ? 'border-[#2563eb] bg-blue-50 text-[#2563eb]' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center p-2 rounded-lg group text-sm font-medium transition-colors duration-150 pl-3">
                            <i data-lucide="shield-check" class="w-5 h-5 {{ $isUsers ? 'text-[#2563eb]' : 'text-slate-400 group-hover:text-[#2563eb]' }} transition-colors"></i>
                            <span class="ms-3">User access</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif

        <!-- Lecturer Section -->
        @if (auth()->check() && (auth()->user()->can('view assigned courses') || auth()->user()->hasRole('lecturer')))
            <div>
                <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Teaching</p>
                <div class="space-y-1">
                    @php $isLecturerCourses = request()->routeIs('lecturer.courses*'); @endphp
                    <a href="{{ route('lecturer.courses') }}"
                       class="sidebar-item border-l-3 {{ $isLecturerCourses ? 'border-[#2563eb] bg-blue-50 text-[#2563eb]' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center p-2 rounded-lg group text-sm font-medium transition-colors duration-150 pl-3">
                        <i data-lucide="graduation-cap" class="w-5 h-5 {{ $isLecturerCourses ? 'text-[#2563eb]' : 'text-slate-400 group-hover:text-[#2563eb]' }} transition-colors"></i>
                        <span class="ms-3">My Courses</span>
                    </a>
                </div>
            </div>
        @endif

        <!-- Student Section -->
        @if (auth()->check() && (auth()->user()->can('view available courses') || auth()->user()->hasRole('student')))
            <div>
                <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Academics</p>
                <div class="space-y-1">
                    @php $isStudentCourses = request()->routeIs('student.courses'); @endphp
                    <a href="{{ route('student.courses') }}"
                       class="sidebar-item border-l-3 {{ $isStudentCourses ? 'border-[#2563eb] bg-blue-50 text-[#2563eb]' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center p-2 rounded-lg group text-sm font-medium transition-colors duration-150 pl-3">
                        <i data-lucide="compass" class="w-5 h-5 {{ $isStudentCourses ? 'text-[#2563eb]' : 'text-slate-400 group-hover:text-[#2563eb]' }} transition-colors"></i>
                        <span class="ms-3">Available Courses</span>
                    </a>

                    @php $isStudentRegister = request()->routeIs('student.register'); @endphp
                    <a href="{{ route('student.register') }}"
                       class="sidebar-item border-l-3 {{ $isStudentRegister ? 'border-[#2563eb] bg-blue-50 text-[#2563eb]' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center p-2 rounded-lg group text-sm font-medium transition-colors duration-150 pl-3">
                        <i data-lucide="edit-3" class="w-5 h-5 {{ $isStudentRegister ? 'text-[#2563eb]' : 'text-slate-400 group-hover:text-[#2563eb]' }} transition-colors"></i>
                        <span class="ms-3">Register Course</span>
                    </a>

                    @php $isStudentRegistrations = request()->routeIs('student.registrations'); @endphp
                    <a href="{{ route('student.registrations') }}"
                       class="sidebar-item border-l-3 {{ $isStudentRegistrations ? 'border-[#2563eb] bg-blue-50 text-[#2563eb]' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center p-2 rounded-lg group text-sm font-medium transition-colors duration-150 pl-3">
                        <i data-lucide="award" class="w-5 h-5 {{ $isStudentRegistrations ? 'text-[#2563eb]' : 'text-slate-400 group-hover:text-[#2563eb]' }} transition-colors"></i>
                        <span class="ms-3">My Registrations</span>
                    </a>
                </div>
            </div>
        @endif

    </div>

    <!-- Bottom User Card -->
    @auth
        <div class="mt-auto border-t border-slate-200 p-4 bg-slate-50/50">
            <div class="flex items-center gap-3 mb-2.5">
                <div class="w-9 h-9 shrink-0 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center text-[#2563eb] text-xs font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-slate-500 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <div class="flex items-center gap-1.5 px-2.5 py-1.5 bg-white rounded-md border border-slate-200">
                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#2563eb]"></i>
                <span class="text-[10px] font-bold text-slate-800 uppercase tracking-wider">
                    {{ auth()->user()->roles->first()?->name ?? 'User' }}
                </span>
            </div>
        </div>
    @endauth
</aside>
