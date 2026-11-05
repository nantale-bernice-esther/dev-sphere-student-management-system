<!DOCTYPE html>
<!-- PAGE: Sign up (guest page, no sidebar/header/footer) -->
<!-- LARAVEL: save as resources/views/auth/register.blade.php (replaces the Jetstream register view) | Jetstream/Fortify already provides GET /register and POST /register -->
<html lang="en">
<head>
 <!-- Start: Head -->
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <!-- Security token used by Laravel for forms -->
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <title>Sign up - Student Management System</title>
 <!-- asset() points to files inside the public folder -->
 <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo.svg') }}">
 <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 <script src="https://cdn.tailwindcss.com"></script>
 <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] } } } };</script>
 <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
 <!-- End: Head -->
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex items-center justify-center px-4 py-8">

 <!-- Start: Sign up card -->
 <div class="w-full max-w-md bg-white border border-slate-200 rounded-2xl shadow-sm p-8">

 <!-- Start: Sign up heading -->
 <div class="flex items-center gap-3 mb-6">
 <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo" class="h-12 w-12">
 <div>
 <h1 class="text-xl font-bold">Student Management System</h1>
 <p class="text-sm text-slate-500">Create your account</p>
 </div>
 </div>
 <!-- End: Sign up heading -->

 <!-- Start: Sign up form | posts to Jetstream's register route; the csrf token is added by the directive below -->
 <form action="{{ route('register') }}" method="POST" class="space-y-4">
 @csrf
 <!-- Full name field | old('name') keeps what the user typed if validation fails -->
 <div>
 <label for="name" class="block text-sm font-medium mb-1">Full name</label>
 <input id="name" name="name" type="text" value="{{ old('name') }}" class="input-field" placeholder="Your full name" required autofocus>
 @error('name')
 <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
 @enderror
 </div>
 <!-- Email field -->
 <div>
 <label for="email" class="block text-sm font-medium mb-1">Email</label>
 <input id="email" name="email" type="email" value="{{ old('email') }}" class="input-field" placeholder="you@example.com" required>
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
 <!-- Confirm password field | must be named password_confirmation for Jetstream's validation -->
 <div>
 <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirm password</label>
 <input id="password_confirmation" name="password_confirmation" type="password" class="input-field" placeholder="********" required>
 </div>
 <!-- Submit button -->
 <button type="submit" class="w-full px-4 py-3 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8]">Sign up</button>
 </form>
 <!-- End: Sign up form -->

 <!-- Start: Login link | goes to the login page -->
 <p class="mt-6 pt-6 border-t border-slate-200 text-sm text-center text-slate-500">
 Already have an account?
 <a href="{{ route('login') }}" class="text-[#2563eb] font-medium hover:underline">Sign in</a>
 </p>
 <!-- End: Login link -->

 </div>
 <!-- End: Sign up card -->

</body>
</html>