<?php
$doc_root_folder = $_SERVER['DOCUMENT_ROOT'] . '/Orbit';
include_once($doc_root_folder . '/src/config/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Logo -->
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>src/resources/icons/orbit-logo-square.svg?version=<?php echo time(); ?>">
    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/src/styles/global.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/src/styles/login.css?version=<?php echo time(); ?>">
    <title>Login Page</title>
</head>

<body>
    <div class="loading-overlay" style="display: none;">
        <span class="loader"></span>
    </div>
    <div class="content">
        <div class="login-container">
            <div class="title-wrapper">
                <p class="title">Log In</p>
                <p class="subtitle">If you dont have an account, <a class="register-link" href="#">register here</a></p>
            </div>
        </div>
        <form class="login-form" method="POST" action="<?php echo BASE_URL; ?>/src/backend/processes/login_handler.php">
            <div class="input-group">
                <label for="username-or-email" class="input-label">Username / Email</label>
                <input type="text" id="username-or-email" name="username_or_email" class="input-field" required>
            </div>
            <div class="input-group">
                <label for="password" class="input-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" class="input-field" required>
                    <div id="togglePassword" class="toggle-password-btn">
                        <div class="icon-show">
                            <?php include $_SERVER['DOCUMENT_ROOT'] . '/Orbit/src/resources/icons/eye-open.svg'; ?>
                        </div>
                        <div class="icon-hide" style="display: none;">
                            <?php include $_SERVER['DOCUMENT_ROOT'] . '/Orbit/src/resources/icons/eye-closed.svg'; ?>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="login-button">Log In</button>
        </form>
    </div>
</body>

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

</html>