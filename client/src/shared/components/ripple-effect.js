document.querySelectorAll('.nav-item a').forEach(link => {
    link.addEventListener('click', function (e) {
        showRipple(this, e);
        setTimeout(() => {
            window.location.href = this.href;
        }, 300);
    });
});

function showRipple(element, e) {
    const ripple = document.createElement('span');
    ripple.classList.add('ripple');
    const rect = element.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    ripple.style.left = `${x}px`;
    ripple.style.top = `${y}px`;
    element.appendChild(ripple);
    setTimeout(() => ripple.remove(), 600);
}

