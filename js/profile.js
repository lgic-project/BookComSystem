
document.getElementById('profile-photo').addEventListener('click', function(event) {
    if (event.target.id === 'view-photo') {
        // Open the view photo modal
        document.getElementById('photo-modal').style.display = 'flex';
    } else if (event.target.id === 'upload-photo') {
        // Show the upload photo form
        document.getElementById('upload-photo-form').style.display = 'block';
    }
});

// Close modal when the user clicks the close button
document.getElementById('close-modal').addEventListener('click', function() {
    document.getElementById('photo-modal').style.display = 'none';
});

// Close modal if user clicks outside of it
window.onclick = function(event) {
    if (event.target === document.getElementById('photo-modal')) {
        document.getElementById('photo-modal').style.display = 'none';
    }
};
