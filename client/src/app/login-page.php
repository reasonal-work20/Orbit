<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

// Include header function and create head section with title and CSS files
include_once ROOT . COMPONENTS . "/header.php";
include_once ROOT . COMPONENTS . "/footer.php";

$cssFiles = ['global.css', 'login-page.css'];
createHead('Login | Orbit', $cssFiles);

?>

<?php
if (isset($_SESSION['loginError'])) {
    echo '<div class="error-message">' . htmlspecialchars($_SESSION['loginError']) . '</div>';
    unset($_SESSION['loginError']);
}
?>
<div class="loading-overlay" style="display: none;">
    <span class="loader"></span>
</div>
<div class="login-container">
    <div class="title-wrapper">
        <p class="title">Log In</p>
    </div>
</div>
<form class="login-form" method="POST" action="<?php echo SERVICES ?>/login-service.php">
    <div class="input-group">
        <label for="email" class="input-label">Email</label>
        <input type="text" id="email" name="email" class="input-field" required>
    </div>
    <div class="input-group">
        <label for="password" class="input-label">Password</label>
        <div class="password-wrapper">
            <input type="password" id="password" name="password" class="input-field" required>
            <div id="togglePassword" class="toggle-password-btn">
                <div class="icon-show">
                    <?php include_once ROOT . ASSETS . '/icons/eye-open.svg'; ?>
                </div>
                <div class="icon-hide" style="display: none;">
                    <?php include_once ROOT . ASSETS . '/icons/eye-closed.svg'; ?>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="login-button">Log In</button>
</form>

<script>
    // Show loading overlay on form submit
    const loginForm = document.querySelector('.login-form');
    const loadingOverlay = document.querySelector('.loading-overlay');

    loginForm.addEventListener('submit', function() {
        loadingOverlay.style.display = 'flex';
    });
</script>

<script>
    const togglePasswordBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const iconShow = togglePasswordBtn.querySelector('.icon-show');
    const iconHide = togglePasswordBtn.querySelector('.icon-hide');

    togglePasswordBtn.addEventListener('click', function() {
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
</script>

<?php
createFooter(false);
?>