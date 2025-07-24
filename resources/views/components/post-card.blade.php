<div>

  @php
    $liked = $post->isLikedBy(Auth()->user());
  @endphp
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center space-x-3 mb-2">
            <img src="{{\Illuminate\Support\Facades\Storage::url($userImage)}}" class="h-9 w-9 rounded-full"/>
            <div>
              <div class="font-semibold">{{$username}}</div>
              <div class="text-xs text-gray-400">{{$timeAgo}}</div>
            </div>
            <i class="text-red-800 cursor-pointer fa-solid fa-trash"></i>
          </div>
          <div class="mb-2 text-gray-800">{{$content ?? ""}}</div>
          <img src="{{\Illuminate\Support\Facades\Storage::url($image)}}" alt="" class="rounded-lg mb-2 max-h-60 w-full object-cover"/>
          <div class="flex items-center space-x-6 text-gray-500 mb-2">
            <button
              class="like-btn flex items-center space-x-1 hover:text-red-800"
              data-post-id="{{$post->id}}"
              
            >
            <i class="{{ $liked ? 'fa-solid text-red-600' : 'fa-regular' }} fa-heart"></i>
            {{-- <span class="like-count">{{ $post->likes->count() }}</span> --}}

            </button>
            
              {{-- <i class="fa-solid fa-heart text-red-800 hover:cursor-pointer"></i> --}}
            <button class="flex items-center space-x-1 hover:text-blue-500"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V10a2 2 0 012-2h2"/></svg><span>5</span></button>
          </div>
          <div class="border-t pt-2">
            <form class="flex items-center space-x-2">
              <input type="text" class="flex-1 border border-gray-200 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Add a comment..."/>
              <button type="submit" class="text-blue-500 font-semibold">Post</button>
            </form>
          </div>
        </div>
</div>