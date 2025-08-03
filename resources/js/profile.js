

window.loadPosts = function(id){
    console.log(id);

    console.log('posts');
    fetch('/home/profile', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.text())
    .then(html => {
        console.log(html)
        // posts_container.innerHTML = html; // Inject only the <x-profile> component or partial
    })
    .catch(err => {
        console.error('Error loading profile posts:', err);
    });
   
}

window.loadFollowers = function(id){
    console.log(id);
 fetch('/home/getFollowers/'+id,{
        method: 'GET',
        headers: {
           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            
        }

        
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        if(data.success){
           const content_load_container = document.getElementById('load_content') ;
           const posts_btn = document.getElementById('posts_btn') ;
           const following_btn = document.getElementById('following_btn') ;
           const follower_btn = document.getElementById('follower_btn') ;

           posts_btn.classList.remove('border-blue-600', 'border-b-2', 'text-blue-600');
           following_btn.classList.remove('border-blue-600', 'border-b-2', 'text-blue-600');
           

            posts_btn.classList.add('text-gray-500');
            following_btn.classList.add('text-gray-500');
            follower_btn.classList.add('border-blue-600', 'border-b-2', 'text-blue-600');


            content_load_container.innerHTML ='' ;
            data.followed_users.forEach(follower=>{
                content_load_container.innerHTML +=`

                <div class="flex items-center justify-between bg-white shadow rounded-lg p-4">
                    <div class="flex items-center space-x-4">
                    <img src="${follower.image_path}" alt="Avatar" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <h2 class="text-gray-800 font-semibold">${follower.follower.name}</h2>
                        <p class="text-gray-500 text-sm">@${follower.follower.nickName}</p>
                    </div>
                    </div>
                    <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-lg shadow">
                    Follow
                    </button>
                </div>

                `;

            });

        }

    })
    .catch(err => {
        console.error('Error fetching posts:', err);
    });
    

}

window.loadFollowing = function(id){
    console.log(id);

    console.log('following');
 fetch('/home/getFollowing/'+id,{
        method: 'GET',
        headers: {
           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            
        }

        
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        if(data.success){
           const content_load_container = document.getElementById('load_content') ;

           const posts_btn = document.getElementById('posts_btn') ;
           const following_btn = document.getElementById('following_btn') ;
           const follower_btn = document.getElementById('follower_btn') ;

           posts_btn.classList.remove('border-blue-600', 'border-b-2', 'text-blue-600');
           following_btn.classList.remove('border-blue-600', 'border-b-2', 'text-blue-600');
           follower_btn.classList.remove('border-blue-600', 'border-b-2', 'text-blue-600');
           

            posts_btn.classList.add('text-gray-500');
            follower_btn.classList.add('text-gray-500');
            following_btn.classList.add('border-blue-600', 'border-b-2', 'text-blue-600');

            content_load_container.innerHTML ='' ;
            data.following_users.forEach(follower=>{
                content_load_container.innerHTML +=`

                <div class="flex items-center justify-between bg-white shadow rounded-lg p-4">
                    <div class="flex items-center space-x-4">
                    <img src="{{\Illuminate\Support\Facades\Storage::url( $user->image_path)}}" alt="Avatar" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <h2 class="text-gray-800 font-semibold">${follower.followed.name}</h2>
                        <p class="text-gray-500 text-sm">@${follower.followed.nickName}</p>
                    </div>
                    </div>
                    <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-lg shadow">
                    Follow
                    </button>
                </div>

                `;

            });

        }

    })
    .catch(err => {
        console.error('Error fetching posts:', err);
    });
    


}