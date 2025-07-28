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
    <section class="flex-1 px-2 md:ml-64 max-w-2xl mx-auto">
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
    <aside class="hidden lg:block fixed top-16 right-0 w-64 h-[calc(100vh-4rem)] bg-white border-l border-gray-100 shadow-lg z-2 overflow-y-auto">
      <div class="p-4">
        <h3 class="font-semibold text-lg mb-3">Following</h3>
        <ul class="space-y-4">
          <li class="flex items-center space-x-3">
            <img src="https://randomuser.me/api/portraits/men/67.jpg" class="h-10 w-10 rounded-full object-cover border-2 border-blue-400"/>
            <div>
              <div class="font-medium">Pam Beesly</div>
              <div class="text-xs text-gray-400">@pam</div>
            </div>
          </li>
          <li class="flex items-center space-x-3">
            <img src="https://randomuser.me/api/portraits/men/66.jpg" class="h-10 w-10 rounded-full object-cover border-2 border-blue-400"/>
            <div>
              <div class="font-medium">Jim Halpert</div>
              <div class="text-xs text-gray-400">@jim</div>
            </div>
          </li>
          <li class="flex items-center space-x-3">
            <img src="https://randomuser.me/api/portraits/men/68.jpg" class="h-10 w-10 rounded-full object-cover border-2 border-blue-400"/>
            <div>
              <div class="font-medium">Dwight Schrute</div>
              <div class="text-xs text-gray-400">@dwight</div>
            </div>
          </li>
          <li class="flex items-center space-x-3">
            <img src="https://randomuser.me/api/portraits/men/60.jpg" class="h-10 w-10 rounded-full object-cover border-2 border-blue-400"/>
            <div>
              <div class="font-medium">Angela Martin</div>
              <div class="text-xs text-gray-400">@angela</div>
            </div>
          </li>
        </ul>
      </div>
    </aside>
  </main>



  <!-- Bottom Navigation for Mobile -->
  <nav class="fixed bottom-0 left-0 right-0 bg-white shadow md:hidden flex justify-around items-center h-14 z-30">
    <a href="#home" class="flex flex-col items-center text-blue-500"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"/></svg><span class="text-xs">Home</span></a>
    <a href="#explore" class="flex flex-col items-center text-gray-500"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l4-4-4-4m8 8l-4-4 4-4"/></svg><span class="text-xs">Explore</span></a>
    <a href="#profile" class="flex flex-col items-center text-gray-500"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg><span class="text-xs">Profile</span></a>
  </nav>

</section>



@endsection