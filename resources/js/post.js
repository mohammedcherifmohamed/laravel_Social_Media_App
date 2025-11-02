 console.log('posts script');

document.addEventListener('DOMContentLoaded', function () {
  console.log('hello');

  // __________ TOGGLE LIKE _______________
 
document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            // console.log("button clicked");

            const postId = this.dataset.postId;
            const toggleLikeUrl = this.dataset.url;

            // console.log("button clicked " + postId);

            const icon = this.querySelector('i');
            const countSpan = this.querySelector('.like-count');

            fetch(toggleLikeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
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

                if (countSpan) {
                    countSpan.textContent = data.likeCount;
                }
            });
        });
    });

// _________________ DELETE POST _______________

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

            const closeBtn = document.getElementById('close-comment-modal');
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    document.getElementById('comment-modal').classList.add('hidden');
                });
            }

            document.querySelectorAll('.comment-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('comment-modal').classList.remove('hidden');
                // you can fetch comments using btn.dataset.postId if needed
            });
            });

            // ___________ FETCH COMMENTS _______________

      document.querySelectorAll('.comment-btn').forEach(element => {
        element.addEventListener('click', function () {
            const postId = element.dataset.postId;
            console.log('post Id : ' + postId);
            const commentUrl = `${window.commentBaseRoute}/${postId}`; // construct full URL

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

                data.data.forEach(user =>{

                    searchResultsList.innerHTML += `
                        <a href="${window.profileRoute}/${user.id}" class="flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-lg transition">
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

   
attachFollowButtonListeners();


}); 
window.attachFollowButtonListeners = function() {
        document.querySelectorAll('.follow-btn').forEach(button => {
            button.addEventListener('click', function () {
                const userId = this.dataset.userId;

                fetch(`/home/ToggleFollowUser/${userId}`, {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.followed) {
                        this.classList.remove("bg-blue-500");
                        this.classList.add("bg-green-500");
                        this.textContent = "Following";
                    } else {
                        this.classList.remove("bg-green-500");
                        this.classList.add("bg-blue-500");
                        this.textContent = "Follow";
                    }
                })
                .catch(error => {
                    alert(error.message || 'Something went wrong');
                });
            });
        });
    }