 console.log('hello');
 
 
 window.toggleSidebar = function () {
    document.getElementById('sidebar').classList.toggle('hidden');
}
 window.toggleDropdown = function () {
    document.getElementById('profileDropdown').classList.toggle('hidden');
}

window.toggleDropdownSearchUsers = function () {
    document.getElementById("searchResultsModal").classList.toggle('hidden');
}

window.openModal = function (id) {
    document.getElementById(id).classList.remove('hidden');
}

window.closeModal = function (id) {
    document.getElementById(id).classList.add('hidden');
}

window.previewImage = function (event) {
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
