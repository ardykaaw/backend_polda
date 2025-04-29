@extends('admin.layouts.app')

@section('title', 'Login')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100 w-full h-full ">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-[400px]">
        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('logo.png') }}" alt="Logo Polda" class="w-32 mb-4">
            <h2 class="text-2xl font-bold text-[#1a237e]">MONITORING DITLANTAS</h2>
            <p class="text-gray-600 mt-2">Admin Panel Login</p>
        </div>

        <form action="{{ route('admin.authenticate') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="nrp" class="block text-gray-700 text-sm font-semibold mb-2">NRP</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-id-card text-gray-400"></i>
                    </div>
                    <input type="text" name="nrp" id="nrp" 
                           class="pl-10 w-full border border-gray-300 rounded-lg py-2 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                           required>
                </div>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" name="password" id="password" 
                           class="pl-10 w-full border border-gray-300 rounded-lg py-2 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                           required>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-500 text-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" class="w-full bg-[#1a237e] hover:bg-blue-900 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                <i class="fas fa-sign-in-alt mr-2"></i> Login
            </button>
        </form>
    </div>
</div>
@endsection
