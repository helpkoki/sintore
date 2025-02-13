// Update the JavaScript to match new field names
document.querySelectorAll('input[name="status"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const emailInput = document.getElementById('emailAddress');
        if (this.value === 'admin') {
            emailInput.type = 'number';
            emailInput.placeholder = 'Admin Number';
            document.querySelector('label[for="emailAddress"]').textContent = 'Admin No:';
        } else {
            emailInput.type = 'email';
            emailInput.placeholder = 'Email Address';
            document.querySelector('label[for="emailAddress"]').textContent = 'Email:';
        }
    });
});

function togglePassword() {
    const passwordField = document.getElementById('password');
    const toggleIcon = document.querySelector('.toggle-password');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}