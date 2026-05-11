document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="role"]');

    const qualSelect = document.getElementById('qualification');
    const qualContainer = document.getElementById('qualification-container');

    function updateVisibility() {
        const selectedRadio = document.querySelector('input[name="role"]:checked');

        if (selectedRadio && selectedRadio.value === 'Lecturer') {
            if (qualContainer) qualContainer.style.display = 'block';
            if (qualSelect) qualSelect.setAttribute('required', 'required');
        } else {
            if (qualContainer) qualContainer.style.display = 'none';
            if (qualSelect) {
                qualSelect.removeAttribute('required');
                qualSelect.value = '';
            }
        }
    }

    radios.forEach(radio => {
        radio.addEventListener('change', updateVisibility);
    });

    // Run once on load
    updateVisibility();
});

function previewImage(event, previewId) {
    const reader = new FileReader();
    const preview = document.getElementById(previewId);

    reader.onload = function () {
        if (reader.readyState === 2) {
            // Clear the "No Image Selected" text and set background
            preview.innerHTML = "";
            preview.style.backgroundImage = `url(${reader.result})`;
            preview.style.backgroundSize = 'cover';
            preview.style.backgroundPosition = 'center';
        }
    }

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}