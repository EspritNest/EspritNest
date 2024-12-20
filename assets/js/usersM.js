// JavaScript to handle modal display for user edit/block actions
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('editUserModal');
    const editButtons = document.querySelectorAll('.edit-btn');
    const blockButtons = document.querySelectorAll('.block-btn');
    const closeModalButton = document.querySelector('.close-btn');

    // Open modal when user clicks on 'Edit' button
    editButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            const userId = event.target.getAttribute('data-user-id');
            openEditUserModal(userId);
        });
    });

    // Close modal when the close button is clicked
    closeModalButton.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Close the modal if the user clicks outside the modal content
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Confirm block user action
    blockButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            const userId = event.target.getAttribute('data-user-id');
            if (confirm('Are you sure you want to block this user?')) {
                // Add your block user logic here
                alert('User blocked successfully.');
            }
        });
    });
});

function openEditUserModal(userId) {
    const modal = document.getElementById('editUserModal');
    modal.style.display = 'flex';
    fetch(`/admin/user/${userId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editUserForm_nom').value = data.nom;
            document.getElementById('editUserForm_email').value = data.email;
            document.getElementById('editUserForm_roles').value = data.roles.join(', ');
            document.getElementById('editUserForm_isVerified').checked = data.isVerified;
        });
}

function closeModal() {
    const modal = document.getElementById('editUserModal');
    modal.style.display = 'none';
}

function confirmBlockUser() {
    // Logic to confirm blocking the user
}
