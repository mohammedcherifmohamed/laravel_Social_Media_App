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
});