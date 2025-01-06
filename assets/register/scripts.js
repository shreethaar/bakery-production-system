document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById('registerForm');

    registerForm.addEventListener('submit', function (event) {
        let isValid = true;

        // Validate Name
        const name = document.getElementById('name').value.trim();
        if (name === '') {
            alert('Name is required.');
            isValid = false;
        }

        // Validate Email
        const email = document.getElementById('email').value.trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === '' || !emailPattern.test(email)) {
            alert('Please enter a valid email address.');
            isValid = false;
        }

        // Validate Username
        const username = document.getElementById('username').value.trim();
        if (username === '') {
            alert('Username is required.');
            isValid = false;
        }

        // Validate Password
        const password = document.getElementById('password').value.trim();
        if (password === '' || password.length < 6) {
            alert('Password must be at least 6 characters long.');
            isValid = false;
        }

        // Validate Role
        const role = document.getElementById('role').value;
        if (role === '') {
            alert('Role is required.');
            isValid = false;
        }

        // Prevent form submission if validation fails
        if (!isValid) {
            event.preventDefault();
        }
    });
});
