<!DOCTYPE html>
<!-- PAGE: Login (guest page, no sidebar/header/footer) -->
<!-- LARAVEL: save as resources/views/auth/login.blade.php (replaces the Jetstream login view) | Jetstream/Fortify already provides GET /login and POST /login -->
<html lang="en">
<head>
 <!-- Start: Head -->
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <!-- Security token used by Laravel for forms -->
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <title>Login - Student Management System</title>
 <!-- asset() points to files inside the public folder -->
 <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo.svg') }}">
 <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 <script src="https://cdn.tailwindcss.com"></script>
 <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] } } } };</script>
 <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
 <!-- End: Head -->
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex items-center justify-center px-4">

 <!-- Start: Login card -->
 <div class="w-full max-w-md bg-white border border-slate-200 rounded-2xl shadow-sm p-8">

 <!-- Start: Login heading -->
 <div class="flex items-center gap-3 mb-6">
 <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo" class="h-12 w-12">
 <div>
 <h1 class="text-xl font-bold">Student Management System</h1>
 <p class="text-sm text-slate-500">Sign in to continue</p>
 </div>
 </div>
 <!-- End: Login heading -->

 <!-- Start: Status message | shows messages such as "password reset link sent" -->
 @if (session('status'))
 <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
 @endif
 <!-- End: Status message -->

 <!-- Start: Login form | posts to Jetstream's login route; the csrf token is added by the directive below -->
 <form action="{{ route('login') }}" method="POST" class="space-y-4">
 @csrf
 <!-- Email field | old('email') keeps what the user typed if login fails -->
 <div>
 <label for="email" class="block text-sm font-medium mb-1">Email</label>
 <input id="email" name="email" type="email" value="{{ old('email') }}" class="input-field" placeholder="you@example.com" required autofocus>
 @error('email')
 <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
 @enderror
 </div>
 <!-- Password field -->
 <div>
 <label for="password" class="block text-sm font-medium mb-1">Password</label>
 <input id="password" name="password" type="password" class="input-field" placeholder="********" required>
 @error('password')
 <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
 @enderror
 </div>
 <!-- Submit button -->
 <button type="submit" class="w-full px-4 py-3 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8]">Sign in</button>
 </form>
 <!-- End: Login form -->

 <!-- Start: Sign up link | goes to the register page -->
 <p class="mt-6 pt-6 border-t border-slate-200 text-sm text-center text-slate-500">
 Don't have an account?
 <a href="{{ route('register') }}" class="text-[#2563eb] font-medium hover:underline">Sign up</a>
 </p>
 <!-- End: Sign up link -->

 </div>
 <!-- End: Login card -->

</body>
</html>