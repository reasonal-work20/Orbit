// Show loading overlay on form submit
const loadingOverlay = document.querySelector('.loading-overlay');

document.addEventListener('submit', function () {
    loadingOverlay.style.display = 'flex';
});