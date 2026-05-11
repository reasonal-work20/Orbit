<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

// Include header function and create head section with title and CSS files
include_once ROOT . COMPONENTS . "/header.php";
include_once ROOT . COMPONENTS . "/footer.php";

$cssFiles = ['login-page.css'];
createHead('Login | Orbit', $cssFiles, false);
?>

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

<script src="<?php echo COMPONENTS; ?>/password-toggle.js"></script>

<?php
createFooter(false);
?>