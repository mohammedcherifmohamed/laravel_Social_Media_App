
window.loadFollowers = function(id){
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
        if(data.success){

           const followsTitle = document.getElementById('followsTitle') ;
           const followersModel = document.getElementById('followersModal') ;
           const followersList = document.getElementById('followersList') ;
           followersModel.classList.remove('hidden');
           followsTitle.textContent = "Followers";

            followersList.innerHTML ='' ;
            data.followed_users.forEach(follower=>{
                console.log(follower);
                // console.log(follower.follower.image_path);
                followersList.innerHTML +=`
                <div class="flex items-center justify-between bg-white shadow rounded-lg p-4">
                    <a href="/home/SeeProfile/+${follower.follower.id}"  class="flex items-center space-x-4">
                        <img src="${follower.follower.image_path}" alt="Avatar" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h2 class="text-gray-800 font-semibold">${follower.follower.name}</h2>
                            <p class="text-gray-500 text-sm">@${follower.follower.nickName}</p>
                        </div>
                    </a>
                   
                    <button
                        class="follow-btn ${follower.follower.is_followed_by_auth_user ? 'bg-green-500 hover:bg-green-600' : 'bg-blue-500 hover:bg-blue-600'} text-white px-4 py-1 rounded-lg shadow transition mt-2"
                        data-user-id="${follower.follower.id}"
                        >
                        ${follower.follower.is_followed_by_auth_user ? 'Following' : 'Follow'}
                    </button>
                </div>

                `;
            });
            attachFollowButtonListeners();
        }

    })
    .catch(err => {
        console.error('Error fetching posts:', err);
    });

}

window.loadFollowing = function(id){
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
        if(data.success){
            const followsTitle = document.getElementById('followsTitle') ;
           const followersModel = document.getElementById('followersModal') ;
           const followersList = document.getElementById('followersList') ;
           followersModel.classList.remove('hidden');
           followsTitle.textContent = "Following";

           followersList.innerHTML ='' ;
            data.following_users.forEach(follower=>{
                console.log(follower);
                followersList.innerHTML +=`

                <div  class=" flex items-center justify-between bg-white shadow rounded-lg p-4">
                    <a href="/home/SeeProfile/+${follower.followed.id}" class="flex items-center space-x-4">
                        <img src="${follower.followed.image_path}" alt="Avatar" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h2 class="text-gray-800 font-semibold">${follower.followed.name}</h2>
                            <p class="text-gray-500 text-sm">@${follower.followed.nickName}</p>
                        </div>
                    </a>
                            
                    <button
                     class="follow-btn ${follower.followed.is_followed_by_auth_user ? 'bg-green-500 hover:bg-green-600' : 'bg-blue-500 hover:bg-blue-600'} text-white px-4 py-1 rounded-lg shadow transition mt-2"
                     data-user-id="${follower.followed.id}"
                     >
                        ${follower.followed.is_followed_by_auth_user ? 'Following' : 'Follow'}
                    </button>
                </div>
                `;
            });
            attachFollowButtonListeners();
        }

    })
    .catch(err => {
        console.error('Error fetching posts:', err);
    });

}