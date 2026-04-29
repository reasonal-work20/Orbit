

// 1. Handle the Back/Forward buttons (Outside the click listener)
window.addEventListener('popstate', function () {
    fetchPage(window.location.href);
});

document.querySelectorAll('.nav-item a').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        const url = this.getAttribute('href');

        showRipple(this, e);
        fetchPage(url);

        document.querySelectorAll('.nav-item').forEach(li => li.classList.remove('active'));
        this.parentElement.classList.add('active');

        history.pushState(null, '', url);
    });
});

function fetchPage(url) {
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            // This MUST match the ID in your PHP <main> tag
            const contentArea = document.getElementById('content-area');
            if (contentArea) {
                contentArea.innerHTML = html;
            }
        })
        .catch(err => console.warn('AJAX Error:', err));
}

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

