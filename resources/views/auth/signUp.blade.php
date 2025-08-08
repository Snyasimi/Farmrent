@extends('auth.layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-green-50">
    <div class="w-full max-w-md p-8 bg-white rounded shadow">
        <h2 class="text-2xl font-bold text-green-700 mb-6 text-center">Farmer Sign Up</h2>
        <form method="POST" action="#" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 mb-2" for="name">Full Name</label>
                <input id="name" type="text" name="name" required autofocus
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-600">
            </div>

            <div>
                <label class="block text-gray-700 mb-2" for="email">Email Address</label>
                <input id="email" type="email" name="email" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-600">
            </div>
            
            <div>
                <label class="block text-gray-700 mb-2" for="password">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-600">
            </div>
            <div>
                <label class="block text-gray-700 mb-2" for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-600">
            </div>

            <button type="submit"
                class="w-full py-2 px-4 bg-green-700 text-white font-bold rounded hover:bg-green-800 transition">Sign Up</button>
        </form>
        <div class="mt-4 text-center">
            <span class="text-gray-600">Already have an account?</span>
            <a href="{{ route('login') }}" class="text-green-700 font-bold hover:underline">Login</a>
        </div>
    </div>
</div>
@endsection