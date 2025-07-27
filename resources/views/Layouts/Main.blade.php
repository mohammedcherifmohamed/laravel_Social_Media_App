<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <title>@yield('title')</title>
</head>
<body>
    

    @yield('content')
    
    

<script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            }
            function toggleDropdown() {
            document.getElementById('profileDropdown').classList.toggle('hidden');
            }
            function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            }
            function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            }
                // Minimal JS for sidebar and dropdown
            function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            }
            function toggleDropdown() {
            document.getElementById('profileDropdown').classList.toggle('hidden');
            }
            function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            }
            function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            }
            function toggleDropdownSearchUsers() {
             document.getElementById("searchResultsModal").classList.toggle('hidden');
            }
        function previewImage(event) {
            const fileInput = event.target;
            const preview = document.getElementById('imagePreview');
            
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
        const toggleLikeUrl = "{{ route('post.toggle_like') }}";
        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
            console.log("button clicked");
            e.preventDefault();
            
            const postId = event.currentTarget.dataset.postId;
            console.log("button clicked"+postId);
            
                const icon = this.querySelector('i');
                const countSpan = this.querySelector('.like-count');

        fetch(toggleLikeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ post_id: postId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.liked) {
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid', 'text-red-600');
                    } else {
                        icon.classList.remove('fa-solid', 'text-red-600');
                        icon.classList.add('fa-regular');
                    }

                    countSpan.textContent = data.likeCount;
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-post').forEach(button => {
            button.addEventListener('click', function () {
            if (!confirm('Are you sure you want to delete this post?')) return;

            const postId = this.dataset.postId;

            fetch(`/post/${postId}/delete`, {
                method: "DELETE",
                headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                this.closest('.bg-white').remove(); 
                } else {
                alert(data.message || 'Something went wrong');
                }
            })
            .catch(error => {
                alert('An error occurred while deleting the post');
                console.error(error);
            });
            });
        });

        // ___________ ADD COMMENT _______________

            const commentForms = document.querySelectorAll('.comment-form');

            commentForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const postId = form.dataset.postId;
                    const userId = form.dataset.userId;
                    const comment = form.querySelector('input[name="comment"]').value;

                    fetch('/comment/add', {
                        method: "POST",
                        headers: {
                           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            post_id: postId,
                            user_id: userId,
                            content: comment
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Comment added successfully');
                            form.reset(); // Clear the input
                            
                        } else {
                            alert(data.message || 'Something went wrong');
                        }
                    })
                    .catch(error => {
                        alert('An error occurred while adding the comment');
                        console.error(error);
                    });
                });
            });

            document.getElementById('close-comment-modal').addEventListener('click', () => {
                document.getElementById('comment-modal').classList.add('hidden');
            });
            document.querySelectorAll('.comment-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('comment-modal').classList.remove('hidden');
                // you can fetch comments using btn.dataset.postId if needed
            });
            });
    const commentRouteTemplate = "{{ url('comment/get_comments') }}/:id";

      document.querySelectorAll('.comment-btn').forEach(element => {
    element.addEventListener('click', function () {
        const postId = element.dataset.postId;
        console.log('post Id : ' + postId);
        const commentUrl = commentRouteTemplate.replace(':id', postId);

        fetch(commentUrl, {
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
            if (data.success) {
                console.log('Comment fetched successfully');
                const commentList = document.getElementById('comment-list');
                commentList.innerHTML = ''; 

                data.data.forEach(comment => {
                    const commentHTML = `
                        <a href="/home/SeeProfile/${comment.user.id}" class="flex items-start space-x-3 bg-gray-50 p-2 rounded-lg">
                            <img src="/storage/${comment.user.image_path ?? 'default.jpg'}" class="w-8 h-8 rounded-full object-cover" alt="User Image" />
                            <div>
                                <div class="text-sm font-semibold text-gray-800">
                                    ${comment.user.name}
                                    <span class="text-xs text-gray-400 ml-2">${new Date(comment.created_at).toLocaleString()}</span>
                                </div>
                                <div class="text-sm text-gray-700">
                                    ${comment.content}
                                </div>
                            </div>
                        </a>
                    `;
                    commentList.insertAdjacentHTML('beforeend', commentHTML);
                });

                document.getElementById('comment-modal').classList.remove('hidden');

            } else {
                alert(data.message || 'Something went wrong');
            }
        })
        .catch(error => {
            alert('An error occurred while fetching the comment');
            console.error(error);
        });
    });
});

//  ______________ SEARCH USERS __________

    // const searchInput = document.getElementById('searchResultsList');
    const searchInput = document.getElementById('searchinput');

    
    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim();
        if (query === '') {
                document.getElementById('searchResultsList').innerHTML = ''; // clear results
                return; // stop the request
        }
        fetch(`/home/searchUsers?query=${encodeURIComponent(query)}`,{
            method:"GET",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                console.log('Comment fetched successfully');
                const searchResultsList = document.getElementById('searchResultsList');
                searchResultsList.innerHTML = ''; 
    const profileRoute = "{{ url('home/SeeProfile') }}"; 

                data.data.forEach(user =>{

                    searchResultsList.innerHTML += `
                        <a href="${profileRoute}/${user.id}" class="flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-lg transition">
                            <img src="/storage/${user.image_path}" class="w-10 h-10 rounded-full object-cover border-2 border-blue-500" alt="User 1" />
                            <div>
                            <div class="font-semibold text-gray-800">@${user.name}</div>
                            <div class="text-sm text-gray-500">${user.nickName}</div>
                            </div>
                        </a>
                    
                    `;
                });
            }else{
                alert(data.message || 'Something went wrong');

            }
           })
           .catch(error => {
            alert('An error occurred while Searching for Users');

           });
        console.log(searchInput.value);
    });
    


// _____________ ToggleFollowUser ____________

        const followBtn = document.getElementById('follow-btn') ;
        
        followBtn.addEventListener('click', function(){
            const userId = this.dataset.userId;
            console.log(userId);

            fetch(`/home/ToggleFollowUser/${userId}`,{
                method: "POST",
                headers:{
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data =>{
                if (data.followed) {
                    followBtn.classList.remove("bg-blue-500");
                    followBtn.classList.add("bg-green-500");
                    followBtn.textContent = "Following";
                } else {
                    followBtn.classList.remove("bg-green-500");
                    followBtn.classList.add("bg-blue-500");
                    followBtn.textContent = "Follow";
                }
            })
            .catch(error =>{
                alert(error.message || 'Something went wrong');
            });

        });

    });

    function ToggleFollowUser(userId){

    }


</script>


</body>
</html>