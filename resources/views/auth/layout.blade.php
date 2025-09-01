<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmRent</title>
    <!-- Tailwind CSS CDN -->
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-green-50 min-h-screen font-sans">

    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="font-bold text-2xl text-green-700">FarmRent</a>
        <div>
            @guest
                <a href="{{ route('login') }}" class="mr-4 text-green-700 font-semibold hover:underline">Login</a>
                <a href="{{ route('signUpPage') }}" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 transition font-semibold">Sign Up</a>
            @else
                <span class="mr-4 text-green-900">Hello, {{ Auth::user()->name }}</span>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="text-green-700 hover:underline font-semibold">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @endguest
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white text-green-900 text-center py-6 shadow-inner mt-16">
        &copy; {{ date('Y') }} FarmRent. All rights reserved.
    </footer>

</body>
</html>