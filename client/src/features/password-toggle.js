
const togglePasswordBtn = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');
const iconShow = togglePasswordBtn.querySelector('.icon-show');
const iconHide = togglePasswordBtn.querySelector('.icon-hide');

togglePasswordBtn.addEventListener('click', function () {
    // 1. Check current state
    const isPassword = passwordInput.getAttribute('type') === 'password';

    // 2. Toggle the input type
    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

    // 3. Swap the icons instantly
    if (isPassword) {
        // Password is now visible, show the "hide" icon
        iconShow.style.display = 'none';
        iconHide.style.display = 'block';
    } else {
        // Password is now hidden, show the "show" icon
        iconShow.style.display = 'block';
        iconHide.style.display = 'none';
    }
});
