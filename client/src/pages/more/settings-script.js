document.addEventListener("DOMContentLoaded", () => {
    const navItems = document.querySelectorAll(".settings-navigation .nav-item");
    const forms = document.querySelectorAll(".settings-form");

    // ==========================================================================
    // 1. SET DEFAULTS ON LOAD
    // ==========================================================================
    // Ensure the profile tab and profile form are marked active immediately
    if (navItems.length > 0 && forms.length > 0) {
        navItems[0].classList.add("active-tab");
        forms[0].classList.add("active");
    }

    // ==========================================================================
    // 2. HANDLE PAGE SWITCHING ON CLICK
    // ==========================================================================
    navItems.forEach((item, index) => {
        item.addEventListener("click", () => {

            // Safety check: Make sure a corresponding form exists for this tab index
            if (!forms[index]) return;

            // Remove active status from all tabs and hide all forms
            navItems.forEach(nav => nav.classList.remove("active-tab"));
            forms.forEach(form => form.classList.remove("active"));

            // Activate the clicked tab and its matching positional form
            item.classList.add("active-tab");
            forms[index].classList.add("active");
        });
    });

    // ==========================================================================
    // 3. SUBMIT BUTTON ACTIVATION
    // ==========================================================================
    const settingsForm = document.querySelector(".settings-form");
    const submitBtn = document.getElementById("update-settings-btn");

    if (settingsForm && submitBtn) {
        const textInputs = settingsForm.querySelectorAll(".text-input");
        const fileInput = settingsForm.querySelector(".file-input");

        function checkFormChanges() {
            let isChanged = false;

            // 1. Check if any text/password fields have input values
            textInputs.forEach(input => {
                if (input.value.trim() !== "") {
                    isChanged = true;
                }
            });

            // 2. Check if a new file/profile image has been staged for upload
            if (fileInput && fileInput.files.length > 0) {
                isChanged = true;
            }

            // 3. Toggle button state based on changes
            if (isChanged) {
                submitBtn.removeAttribute("disabled");
                submitBtn.classList.add("btn-ready"); // Class hook for glowing styling transitions
            } else {
                submitBtn.setAttribute("disabled", "true");
                submitBtn.classList.remove("btn-ready");
            }
        }

        // Listen for typing or pasting changes across password fields
        textInputs.forEach(input => {
            input.addEventListener("input", checkFormChanges);
        });

        // Listen for image selection updates
        if (fileInput) {
            fileInput.addEventListener("change", checkFormChanges);
        }
    }
});