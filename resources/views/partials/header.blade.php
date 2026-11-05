{{-- resources/views/partials/header.blade.php --}}
<header class="fixed top-0 z-50 w-full bg-white border-b border-slate-200">
    <div class="px-3 py-2.5 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <label for="sidebar-toggle" class="inline-flex items-center p-2 text-slate-500 rounded-lg sm:hidden hover:bg-slate-100 cursor-pointer focus:outline-none">
                    <span class="sr-only">Open sidebar</span>
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </label>
                <a href="{{ route('home') }}" class="flex items-center ms-2 md:me-8 group">
                    <img src="{{ asset('assets/img/logo.svg') }}" alt="Student Management System" class="h-10 w-10 me-3">
                    <div class="flex flex-col">
                        <span class="font-bold text-slate-900 text-base leading-tight group-hover:text-[#2563eb] transition-colors">Student Management System</span>
                        <span class="text-xs text-slate-500">Makerere University Business School</span>
                    </div>
                </a>
            </div>

            <!-- Header user menu -->
            @auth
                <details class="menu-dropdown relative">
                    <summary class="flex items-center gap-2 bg-slate-50 rounded-lg p-1.5 text-sm border border-slate-200 hover:bg-slate-100 cursor-pointer list-none select-none">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-[#2563eb] border border-blue-200 text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <div class="hidden md:block text-left mr-1">
                            <div class="text-xs font-semibold text-slate-900 leading-tight">{{ auth()->user()->name }}</div>
                            <div class="text-[10px] text-slate-500 font-medium capitalize">
                                {{ auth()->user()->roles->first()?->name ?? 'User' }}
                            </div>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                    </summary>

                    <div class="absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-xl shadow-lg z-50 overflow-hidden">
                        <div class="px-4 py-3 border-b border-slate-100 bg-slate-50">
                            <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                            <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-semibold rounded bg-blue-100 text-[#2563eb] capitalize">
                                {{ auth()->user()->roles->first()?->name ?? 'User' }}
                            </span>
                        </div>

                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm font-medium text-amber-700 hover:bg-amber-50 transition-colors">
                                <i data-lucide="log-out" class="w-4 h-4 mr-2 text-amber-600"></i>
                                Sign out
                            </button>
                        </form>
                    </div>
                </details>
            @endauth
        </div>
    </div>
</header>
