  @props(['posts', 'user', 'follows']) 

  
  <!-- Profile Page Content -->
  <section class="max-w-4xl mx-auto mt-20 mb-10 bg-white rounded-lg shadow p-0 overflow-hidden flex flex-col ">
    <!-- Left: Profile Info -->
@if (session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 shadow text-center">
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 shadow">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="w-full flex flex-col items-center justify-center p-8 bg-gray-50">
      <div class="relative group">
        <img id="profilePic" src="{{\Illuminate\Support\Facades\Storage::url( $user->image_path)}}" class="h-32 w-32 rounded-full border-4 border-white shadow-lg object-cover mb-4"/>
        
      </div>
      <div class="font-bold text-2xl text-center mt-2">{{$user->name}}</div>
      <div class="text-gray-500 mb-2 text-center">{{$user->nickName ?? ""}}</div>
      <div class="mb-4 text-center">bio here</div>
      
      @if(Auth::id() === $user->id)
        <button onclick="openModal('editProfileModal')" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition mt-2">Edit Profile</button>
      @endif
      @if(Auth::id() != $user->id)
        <button
          data-user-id="{{ $user->id }}"
          id="follow-btn" 
          class="{{ $follows ? 'bg-green-500 hover:bg-green-600' : 'bg-blue-500 hover:bg-blue-600' }} text-white px-4 py-1 rounded-lg shadow transition mt-2"
        >
          {{ $follows ? 'Following' : 'Follow' }}
        </button>
    @endif

      </div>
    <!-- Right: Cover + Tabs + Posts + Followed People -->
    <div class="w-full flex flex-col ">
      <div class="flex-1 flex flex-col">
        
        <div class="flex justify-center space-x-8 border-b pb-2 mb-4 mt-4">
          <button id="posts_btn" onclick="loadPosts({{$user->id}})"  class="font-semibold text-blue-600 border-b-2 border-blue-600 pb-1">Posts</button>
          <button id="follower_btn" onclick="loadFollowers({{$user->id}})" class="text-gray-500 hover:text-blue-600 ">Followers</button>
          <button id="following_btn" onclick="loadFollowing({{$user->id}})" class="text-gray-500 hover:text-blue-600">Following</button>
        
        </div>
        <div id="load_content">
          <div id="posts_container" class="space-y-4 px-6 pb-6">
              @foreach($posts as $post)
                  <x-post-card
                        :post="$post"
                        :content="$post->content"
                        :userImage="$post->user->image_path"
                        :image="$post->image_path"
                        :timeAgo="$post->created_at"
                        :username="$post->name"
                  ></x-post-card>
              @endforeach
              
            </div>
        </div>
   
      </div>
      <!-- Followed People Section -->
      
    </div>
  </section>
  <!-- Followers Modal -->
<div id="followersModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
    <button class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl" onclick="closeModal('followersModal')">&times;</button>
    <h2 id="followsTitle" class="text-xl font-bold mb-4">Followers</h2>
    <div id="followersList" class="space-y-4 overflow-y-auto max-h-96">
      <!-- Followers will be appended here -->
    </div>
  </div>
</div>


  <!-- Edit Profile Modal -->
  <div id="editProfileModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative" tabindex="-1" id="editProfileDialog">
      <button class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl" onclick="closeModal('editProfileModal')">&times;</button>
      <h2 class="text-xl font-bold mb-4">Edit Profile</h2>
      <form action="{{ route('profile.update')}}" method="POST" class="space-y-4" id="editProfileForm"  enctype="multipart/form-data"  >
        @csrf
        <div class="flex flex-col items-center">
          <label for="editProfilePic" class="relative cursor-pointer group">
            <img id="editProfilePicPreview" src="{{\Illuminate\Support\Facades\Storage::url( $user->image_path)}}" class="h-24 w-24 rounded-full object-cover border-2 border-blue-400"/>
            <span class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-40 rounded-full transition group-hover:opacity-100 opacity-0">
              <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0L9 13zm-6 6h6v-2a2 2 0 012-2h2v6H3a2 2 0 01-2-2v-2z"/></svg>
            </span>
            <input name="image" id="editProfilePic" type="file" accept="image/*" class="hidden" onchange="previewProfilePic(event)" />
          </label>
          <span class="text-xs text-gray-400 mt-1">Click to change photo</span>
        </div>
        <div>
          <label class="block text-sm font-medium mb-1" for="editUsername">Username <span class="text-red-500">*</span></label>
          <input name="username" id="editUsername" value="{{$user->name}}" type="text" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter new username" required />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1" for="editUsername">NickName <span class="text-red-500">*</span></label>
          <input name="nickName" id="editUsername" value="{{$user->nickName}}" type="text" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter new NickName"  />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1" for="editPassword">Old Password <span class="text-red-500">*</span></label>
          <div class="relative">
            <input name="oldPassword" id="editPassword" type="password"  class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 pr-10" placeholder="Enter Old password" required />
            <button type="button" tabindex="-1" onclick="togglePassword()" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700">
              <svg id="eyeIcon" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-.274.832-.67 1.613-1.17 2.318M15.232 15.232A3 3 0 0112 17a3 3 0 01-3-3"/></svg>
            </button>
          </div>
          <span class="text-xs text-gray-400">Minimum 6 characters</span>
        </div>
        <div>
          <label class="block text-sm font-medium mb-1" for="editPassword">Password <span class="text-red-500">*</span></label>
          <div class="relative">
            <input  name="newPassword" id="editPassword" type="password" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 pr-10" placeholder="Enter new password"  />
            <button type="button" tabindex="-1" onclick="togglePassword()" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700">
              <svg id="eyeIcon" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-.274.832-.67 1.613-1.17 2.318M15.232 15.232A3 3 0 0112 17a3 3 0 01-3-3"/></svg>
            </button>
          </div>
          <span class="text-xs text-gray-400">Minimum 6 characters</span>
        </div>
        <div class="flex justify-end">
          <button type="button" onclick="closeModal('editProfileModal')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg mr-2 hover:bg-gray-300">Cancel</button>
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Save</button>
        </div>
        <div id="editProfileSuccess" class="hidden text-green-600 text-center font-semibold mt-2">Profile updated successfully!</div>
      </form>
    </div>
  </div>