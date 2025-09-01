<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Renter Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
      @vite('resources/css/app.css')
  @vite('resources/js/app.js')
</head>
<body class="bg-green-50 min-h-screen">

    {{-- Navigation Bar --}}
    <nav class="bg-green-700 text-white shadow mb-10">
        <div class="max-w-6xl mx-auto flex justify-between items-center py-4 px-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('homepage') }}"
                   class="font-bold text-2xl hover:text-green-200 transition">FarmRent Dashboard</a>
                <a href="{{ route('equipment.index') }}"
                   class="hover:text-green-200 px-3 py-2 rounded transition">My Equipment</a>
                <a href="{{ route('rentals.index') }}"
                   class="hover:text-green-200 px-3 py-2 rounded transition">My Rentals</a>

                   <a href="{{ route('rentEquipment') }}"
                   class="hover:text-green-200 px-3 py-2 rounded transition">Rent new Equipment</a>
                  
      
            </div>
            <div>
                @auth
                    <span class="mr-4">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <input type="text" value={{ auth()->user()->id }} name="user_id" disabled hidden>
                        <button type="submit" class="hover:text-green-200">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-green-200">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4">
        @yield('content')
    </main>

</body>

</html>
