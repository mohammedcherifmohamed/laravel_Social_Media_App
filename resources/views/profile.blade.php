@extends('Layouts.Main')

@include('includes.nav')
@include('includes.sidebar')

@section('title')
    Profile Page
@endsection

@section('content')
   <x-profile
   :posts="$posts"
   :user="$user"
   ></x-profile>
@endsection


