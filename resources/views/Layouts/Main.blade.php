<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- <script src="//unpkg.com/alpinejs" defer></script> -->

    @livewireStyles 
    <title>@yield('title')</title>


</head>
<body >
    

    @yield('content')
    
    


  

<script>
    window.commentBaseRoute = "{{ url('comment/get_comments') }}"; 
     window.profileRoute = "{{ url('home/SeeProfile') }}"; 

</script>
  @livewireScripts
</body>
</html>