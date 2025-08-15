<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AgriRentals - Empowering Modern Farming</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
  @vite('resources/js/app.js')

</head>
<body class="bg-green-50 font-sans">
    <nav class="flex items-center justify-between px-8 py-4 bg-white shadow">
        <a href="/" class="text-2xl font-bold text-green-700">Farm Rent</a>
        <div>
            <a href="{{ route('login') }}" class="text-green-700 font-semibold hover:underline mr-4">Login</a>
            <a href="{{ route('signUpPage') }}" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 transition">Get Started</a>
        </div>
    </nav>
    <main class="flex flex-col lg:flex-row items-center justify-between max-w-6xl mx-auto px-6 py-16">
        <div class="w-full lg:w-1/2 mb-16 lg:mb-0">
            <h1 class="text-5xl font-bold text-green-800 mb-6 leading-tight">Empowering Modern Farming,<br>One Rental at a Time.</h1>
            <p class="text-green-900 text-lg mb-8">
                Rent, lend, and manage agricultural equipment with ease. AgriRentals connects farmers and equipment owners for a smarter, more productive farming community.
            </p>
            <div class="flex items-center gap-4">
                <a href="{{ route('signUpPage') }}" class="bg-green-700 text-white px-6 py-3 rounded-lg text-lg font-semibold shadow hover:bg-green-800 transition">Get Started</a>
                <a href="#features" class="text-green-700 font-semibold hover:underline transition">Learn More</a>
            </div>
        </div>
        <div class="w-full lg:w-1/2 flex justify-center">
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80"
                 alt="Farm Equipment"
                 class="rounded-2xl shadow-lg border-4 border-green-100 max-w-md">
        </div>
    </main>
    <section id="features" class="bg-white py-16">
        <div class="max-w-5xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-green-50 p-6 rounded-lg shadow text-center">
                    <div class="text-5xl mb-4">🚜</div>
                    <h3 class="text-xl font-semibold mb-2 text-green-800">List Equipment</h3>
                    <p class="text-green-900">Equipment owners can easily list their farm machinery and set availability and rates.</p>
                </div>
                <div class="bg-green-50 p-6 rounded-lg shadow text-center">
                    <div class="text-5xl mb-4">🤝</div>
                    <h3 class="text-xl font-semibold mb-2 text-green-800">Book & Rent</h3>
                    <p class="text-green-900">Farmers browse, compare, and book the equipment they need, right when they need it.</p>
                </div>
                <div class="bg-green-50 p-6 rounded-lg shadow text-center">
                    <div class="text-5xl mb-4">📈</div>
                    <h3 class="text-xl font-semibold mb-2 text-green-800">Grow Together</h3>
                    <p class="text-green-900">Boost productivity and profits while building a sustainable farming ecosystem.</p>
                </div>
            </div>
        </div>
    </section>
    <footer class="text-center text-green-900 py-8">
        &copy; {{ date('Y') }}Farm Rent. All rights reserved.
    </footer>
</body>
</html>