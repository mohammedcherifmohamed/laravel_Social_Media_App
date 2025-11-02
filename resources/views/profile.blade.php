@extends('Layouts.Main')

@include('includes.nav')
@include('includes.sidebar')

@section('title')
    Profile Page
@endsection

@section('content')
   <x-profile
   :follows="$follows"
   :posts="$posts"
   :user="$user"
   ></x-profile>

     <!-- Bottom Navigation for Mobile -->
  <nav class="fixed bottom-0 left-0 right-0 bg-white shadow lg:hidden flex justify-around items-center h-14 z-30">
    <a href="{{route('home.load')}}" class="flex flex-col items-center text-blue-500"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"/></svg><span class="text-xs">Home</span></a>
    <a href="{{route('home.loadExplore')}}" class="flex flex-col items-center text-gray-500"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l4-4-4-4m8 8l-4-4 4-4"/></svg><span class="text-xs">Explore</span></a>
    <a href="{{route('profile.load')}}" class="flex flex-col items-center text-gray-500"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg><span class="text-xs">Profile</span></a>
  </nav>
@endsection



