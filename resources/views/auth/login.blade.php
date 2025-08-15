@extends('auth.layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-green-50">
    <div class="w-full max-w-md p-8 bg-white rounded shadow">
        <h2 class="text-2xl font-bold text-green-700 mb-6 text-center">Farmer Login</h2>
        <form method="POST" action="{{ route('authenticate') }}" class="space-y-4">
            @csrf
        
            <div>
                <label class="block text-gray-700 mb-2" for="email">Email Address</label>
                <input id="email" type="email" name="email" required autofocus
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-600 @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ "Provided details do not exist" }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-gray-700 mb-2" for="password">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-600 @error('password') border-red-500 @enderror">
                
            </div>
        
            {{-- General authentication error --}}
            @if(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-2">
                    {{ session('error') }}
                </div>
            @endif
        
            <div class="flex items-center justify-between">
                <div>
                    <input type="checkbox" name="remember" id="remember" class="mr-1">
                    <label for="remember" class="text-gray-700 text-sm">Remember me</label>
                </div>
                <a href="#" class="text-green-700 text-sm hover:underline">
                    Forgot Password?
                </a>
            </div>
        
            <button type="submit"
                class="w-full py-2 px-4 bg-green-700 text-white font-bold rounded hover:bg-green-800 transition">Login</button>
        </form>
        <div class="mt-4 text-center">
            <span class="text-gray-600">Don't have an account?</span>
            <a href="#" class="text-green-700 font-bold hover:underline">Sign Up</a>
        </div>
    </div>
</div>
@endsection