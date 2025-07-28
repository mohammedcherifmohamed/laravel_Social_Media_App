@extends('Layouts.Main')

@section('title')
    home page
@endsection

@section('content')


<section class="bg-gray-100 min-h-screen flex flex-col">


@include('includes.nav')
@include('includes.sidebar')
    

  <!-- Main Content -->
  <main id="mainContent" class="flex-1 flex flex-col md:flex-row pt-20 max-w-7xl mx-auto w-full">
    <!-- Feed Section -->
<section class="flex-1 px-4 max-w-2xl mx-auto w-full">
      <!-- Create New Post -->
      <div class="bg-white rounded-lg shadow p-4 mb-6 mt-4">
        <div class="flex items-start space-x-3">
          <img src="{{\Illuminate\Support\Facades\Storage::url( Auth::user()->image_path)}}" class="h-10 w-10 rounded-full border-2 border-blue-500"/>
          <form action="{{route('post.add')}}" method="POST"  class="flex-1" enctype="multipart/form-data">
           @csrf
            <textarea name="content" class="w-full border border-gray-200 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none" rows="2" placeholder="What's on your mind?"></textarea>
            <div class="flex items-center justify-between mt-2">
              <label class="flex items-center space-x-2 cursor-pointer">
                <i class="fa-solid fa-image"></i>
                  <input id="imageInput" name="image" type="file" accept="image/*" class="hidden" onchange="previewImage(event)" />
                    <img id="imagePreview" src="#" alt="Image Preview" class="rounded-lg mb-2 max-h-60 w-full object-cover hidden"/>

              </label>
              <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded-lg shadow hover:bg-blue-600 transition">Post</button>
            </div>
          </form>
        </div>
      </div>
      <!-- Posts List -->
      <div class="space-y-6">
       

        {{-- reel image load --}}
        @foreach($posts as $post)
            <x-post-card
              :post="$post"
              :content="$post->content"
              :userImage="$post->user->image_path"
              :image="$post->image_path"
              :timeAgo="$post->created_at"
              :username="$post->user->name"
            ></x-post-card>
        @endforeach

      </div>
    </section>
    
    <!-- Following Section on Right -->
    <aside id="chat_sidebar" class="hidden lg:block fixed top-16 right-0 w-64 h-[calc(100vh-4rem)] bg-white border-l border-gray-100 shadow-lg z-2 overflow-y-auto">
      <div class="p-4">
        <h3 class="font-semibold text-lg mb-3">Following</h3>
        <ul class="space-y-4">
          @foreach($followedUsers as $follows)
            <li class="flex items-center space-x-3"data-following-id="{{$follows->id}}"onclick="openChat($follows->id)">
              <img src="{{\Illuminate\Support\Facades\Storage::url( $follows->image_path)}}"  class="cursor-pointer h-10 w-10 rounded-full object-cover border-2 border-blue-400"/>
              <div class="cursor-pointer" >
                <div class="font-medium">@ {{$follows->name}}</div>
                <div class="text-xs text-gray-400">{{$follows->nickName}}</div>
              </div>
            </li>
         @endforeach
        </ul>
      </div>
    </aside>
  </main>

  <!-- Container for multiple chat boxes -->
<div id="chat-container" class="hidden fixed bottom-16 right-4 flex gap-4 z-50">
    <!-- Chat boxes will be injected here -->
    <section  class="chat-box w-80 h-[500px]  bg-white shadow-lg rounded-lg flex flex-col">
     <div  class="flex items-center justify-between p-4 border-b">
          <h2 class="text-xl font-bold">محادثة مع Mohamed</h2>
          <button onclick="hidechatBox()" class="text-gray-500 hover:text-red-600 text-xl leading-none">
              &times;
          </button>
      </div>
      <!-- Messages Area -->
      <div class="flex-1 overflow-y-auto space-y-2 px-4 py-2 bg-gray-50">
          <!-- Example Sent Message -->
          <div class="flex justify-end">
              <div class="max-w-[70%] px-4 py-2 rounded-lg bg-blue-500 text-white text-sm">
                  مرحباً، كيف حالك؟
              </div>
          </div>
          <!-- Example Received Message -->
          <div class="flex justify-start">
              <div class="max-w-[70%] px-4 py-2 rounded-lg bg-gray-200 text-gray-800 text-sm">
                  بخير، وأنت؟
              </div>
          </div>
      </div>

      <!-- Message Input -->
      <form action="" method="POST" class="p-4 border-t flex items-center space-x-2">
          @csrf
          <input type="hidden" name="receiver_id" value="">
          <input
              type="text"
              name="message"
              placeholder="اكتب رسالتك..."
              required
              class="flex-1 border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
          >
          <button
              type="submit"
              class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
          >
              إرسال
          </button>
      </form>
  </section>

</div>



  <!-- Bottom Navigation for Mobile -->
  <nav class="fixed bottom-0 left-0 right-0 bg-white shadow lg:hidden flex justify-around items-center h-14 z-30">
    <a href="{{route('home.load')}}" class="flex flex-col items-center text-blue-500"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"/></svg><span class="text-xs">Home</span></a>
    <a href="{{route('home.loadExplore')}}" class="flex flex-col items-center text-gray-500"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l4-4-4-4m8 8l-4-4 4-4"/></svg><span class="text-xs">Explore</span></a>
    <a href="{{route('profile.load')}}" class="flex flex-col items-center text-gray-500"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg><span class="text-xs">Profile</span></a>
    <button id="toggle_side_btn" class=" mr-2" onclick="toggleChatbar()">
         <svg class="h-6 w-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
       </button>
  </nav>

</section>



@endsection