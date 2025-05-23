@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-center">
    <div class="col-md-6 col-lg-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h4 class="text-center text-lg font-semibold mb-4"><i class="fas fa-sign-in-alt"></i> Login</h4>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('email') border-red-500 @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('password') border-red-500 @enderror" id="password" name="password" required>
                    </div>
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 w-full">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection