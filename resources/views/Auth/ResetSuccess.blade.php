@extends('layout.Main')

@section('title', 'Success')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-green-50">
        <div class="bg-white shadow-lg rounded-lg p-8 text-center">
            <h1 class="text-2xl font-bold text-green-600 mb-4">✅ Password Reset Successful</h1>

            <a href="{{ route('login') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                Back to login page
            </a>
        </div>
    </div>
@endsection
