
    

  <!-- Top Navigation Bar -->
  <nav class="bg-white shadow fixed w-full z-20 top-0 left-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <button class="lg:hidden mr-2" onclick="toggleSidebar()">
            <svg class="h-6 w-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
          </button>
          <span class="font-bold text-xl text-blue-600">SocialApp</span>
        </div>
        <div onclick="toggleDropdownSearchUsers()" id="search-users-button" class="  flex items-center justify-between bg-white px-4 py-3 rounded-xl shadow-md  gap-x-4 max-w-md mx-auto mb-4 cursor-pointer hover: bg-gray-50 transition">
          <h3 class="text-lg font-semibold text-gray-800">Search Users</h3>
          <i class="fa-solid fa-magnifying-glass text-blue-500 text-xl"></i>
        </div>

        <div class="flex items-center space-x-4">
          <button class="relative">
            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">3</span>
          </button>
          <button>
            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h12a2 2 0 012 2z"/></svg>
          </button>
          <div class="relative">
            <button onclick="toggleDropdown()" class="flex items-center focus:outline-none">
              <img src="{{\Illuminate\Support\Facades\Storage::url( Auth::user()->image_path)}}" class="h-8 w-8 rounded-full border-2 border-blue-500"/>
              <svg class="h-4 w-4 ml-1 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-99">
              <a href="{{route('profile.load')}}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">My Profile</a>
              <a href="{{route('logout')}}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

<!-- Centered Search Modal (Input + Results) -->
<div id="searchResultsModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 space-y-4 relative">
    
    <!-- Close Button -->
    <button 
      onclick="toggleDropdownSearchUsers()" 
      class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-2xl"
    >
      <i class="fa-solid fa-rectangle-xmark"></i>
    </button>

    <!-- Search Input -->
    <input type="text"
           placeholder="Search for users..."
           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
           id="searchinput"
           />

    <!-- Search Results -->
    <div id="searchResultsList" class="space-y-3 max-h-64 overflow-y-auto">
      <!-- Users list here (as before) -->
      <!-- User 1 -->
   
    </div>
  </div>
</div>


