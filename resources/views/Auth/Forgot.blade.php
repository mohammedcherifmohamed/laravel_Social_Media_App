@extends('Layouts.Main')
    
@section('title', 'Forgot password')

@section('content')

    {{-- show success/errors messages --}}

    @if(session('error_forgot'))
        <x-alert type="error" >
            {{session('error_forgot')}}
        </x-alert>
    @endif


    <div class="container mx-auto px-4 py-12">
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden card">
            <div class="px-6 py-8">
                <div class="text-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800">Forgot Password</h2>
                    <p class="text-gray-600 mt-2">Enter your email to reset your password</p>
                </div>
                
                <form action="{{route("forgot.post")}}" method="POST" id="forgotPasswordForm" class="space-y-6">
                    @csrf
                    <div class="rounded-lg bg-blue-50 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Enter your email address and we'll send you a link to reset your password.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email" required 
                                class="input-field py-3 pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                placeholder="you@example.com">
                        </div>
                    </div>
                    
                    <div>
                        <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                            <i class="fas fa-paper-plane mr-2"></i> Send Reset Link
                        </button>
                    </div>
                </form>
                
                @if(session('success_forgot'))
                    <div id="successMessage" class="success-message mt-6 rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    Password reset link sent successfully!
                                </p>
                                <p class="mt-2 text-sm text-green-700">
                                    Check your email for instructions to reset your password. The link will expire in 1 Min.
                                </p>
                            </div>
                        </div>
                    </div>
             @endif
                
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Remember your password? 
                        <a href="{{route("login")}}" class="font-medium text-blue-600 hover:text-blue-500 transition duration-300">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
        

   @endsection