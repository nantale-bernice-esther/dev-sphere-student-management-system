<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - Student Management System</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo.svg') }}">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN for instant prototype alignment -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2563eb',
                    }
                }
            }
        };
    </script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- App JavaScript -->
    <script src="{{ asset('assets/js/app.js') }}" defer></script>

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex flex-col">

    <!-- Mobile Drawer Toggle Checkbox & Backdrop -->
    <input type="checkbox" id="sidebar-toggle" class="peer hidden" aria-hidden="true">
    <label for="sidebar-toggle" class="fixed inset-0 bg-slate-900/40 z-30 hidden peer-checked:block sm:!hidden backdrop-blur-xs transition-opacity"></label>

    <!-- Reusable Header -->
    @include('partials.header')

    <!-- Reusable Sidebar Navigation -->
    @include('partials.sidebar')

    <!-- Main Content Area with Header offset and Sidebar margin -->
    <div class="sm:ml-64 pt-16 flex-1 flex flex-col min-h-screen">
        <main class="flex-1 p-4 lg:p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Reusable Flash Alerts & Validation Errors -->
                @include('partials.alerts')

                <!-- Content Section -->
                @yield('content')
                {{ $slot ?? '' }}
            </div>
        </main>

        <!-- Reusable Footer -->
        @include('partials.footer')
    </div>

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
