@extends('user.layout')

@section('content')
<div class="min-h-screen bg-green-50 flex flex-col items-center justify-center">
    <div class="max-w-2xl w-full p-8 bg-white rounded shadow text-center mt-16">
        <h1 class="text-4xl font-bold text-green-700 mb-4">Welcome to FarmRent</h1>
        <p class="text-lg text-gray-700 mb-6">
            Connecting farmers to affordable farm equipment rentals. Easily find, rent, and manage your equipment needs.
        </p>
        <div class="flex flex-col md:flex-row gap-4 justify-center">
            <a href="{{ route('login') }}" class="py-2 px-8 bg-green-700 text-white rounded font-bold hover:bg-green-800 transition">Login</a>
            <a href="{{ route('signUpPage') }}" class="py-2 px-8 bg-white border border-green-700 text-green-700 rounded font-bold hover:bg-green-50 transition">Sign Up</a>
        </div>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-green-100 rounded p-4">
                <h2 class="text-xl font-bold text-green-700">For Farmers</h2>
                <p class="text-gray-700 mt-2">Browse available equipment, manage your rentals, and grow your farm efficiently.</p>
            </div>
            <div class="bg-green-100 rounded p-4">
                <h2 class="text-xl font-bold text-green-700">For Owners</h2>
                <p class="text-gray-700 mt-2">List your farm equipment, connect with renters, and earn income from idle assets.</p>
            </div>
        </div>
    </div>
</div>
@endsection