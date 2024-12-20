document.addEventListener('DOMContentLoaded', () => {
    const discussionItems = document.querySelectorAll('.discussions-list ul li');

    discussionItems.forEach(item => {
        item.addEventListener('click', () => {
            // Remove active class from all items
            discussionItems.forEach(i => i.classList.remove('active'));
            // Add active class to the clicked item
            item.classList.add('active');
        });
    });
});