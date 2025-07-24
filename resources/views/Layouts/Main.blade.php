<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
function previewImage(event) {
    const fileInput = event.target;
    const preview = document.getElementById('imagePreview');
    
    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden'); // remove hidden class
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
});


</script>
</body>
</html>