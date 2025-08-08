<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmRent</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 min-h-screen">

    <nav class="bg-green-700 text-white px-4 py-3 flex justify-between items-center shadow">
        <a href="{{ url('/') }}" class="font-bold text-xl">FarmRent</a>
        <div>
            @guest
                <a href="{{ route('login') }}" class="mr-4 hover:underline">Login</a>
                <a href="{{ route('signUpPage') }}" class="hover:underline">Sign Up</a>
            @else
                <span class="mr-4">Hello, {{ Auth::user()->name }}</span>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="hover:underline">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @endguest
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-green-700 text-white text-center py-3 mt-8">
        &copy; {{ date('Y') }} FarmRent. All rights reserved.
    </footer>

</body>
</html>