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