    // Get references to the buttons
    var button1 = document.getElementById('button1');
    var button2 = document.getElementById('button2');

    // Add click event listener for button1
    button1.addEventListener('click', function() {
        window.location.href = 'admin/admin.php';
    });

    // Add click event listener for button2
    button2.addEventListener('click', function() {
        window.location.href = 'user/login.php'; // Replace with actual URL for user page
    });