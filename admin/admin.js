document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent form from submitting normally

    const username = document.getElementById('username').value;
    const loginMessage = document.getElementById('loginMessage');
    const button = document.querySelector('.submitbtn');

    fetch('', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `username=${encodeURIComponent(username)}`,
    })
        .then((response) => response.text())
        .then((response) => {
            if (response === 'valid') {
                loginMessage.textContent = 'Username verified!';
                button.textContent = 'Log in'; // Change button text
                button.style.backgroundColor = '#4CAF50'; // Optional styling
            } else {
                loginMessage.textContent = 'Invalid username. Please try again.';
                loginMessage.style.color = 'red';
            }
        })
        .catch((error) => {
            loginMessage.textContent = 'An error occurred. Please try again later.';
            loginMessage.style.color = 'red';
            console.error('Error:', error);
        });
});
