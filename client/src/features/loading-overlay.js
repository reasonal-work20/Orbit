// Show loading overlay on form submit
const loginForm = document.querySelector('.login-form');
const loadingOverlay = document.querySelector('.loading-overlay');

loginForm.addEventListener('submit', function () {
    loadingOverlay.style.display = 'flex';
});