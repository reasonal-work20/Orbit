<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

// Include the header

include_once ROOT.COMPONENTS . "/index-header.php";

?>

<img id='orbit-logo' src="<?php echo ASSETS; ?>/icons/orbit-logo.svg" alt="orbit logo" aria-hidden="true">
        <p class="title">
            Your personal campus navigator and transport manager
        </p>
        <div class="login-button">
            <a href="<?php echo ROOT.ASSETS; ?>/src/app/auth/login_page.php">Log In
                <div class="icon">
                    <?php include_once ROOT.ASSETS . "/icons/login-square-icon.svg" ?>
                </div>
            </a>
        </div>

<?php
include_once ROOT.COMPONENTS . "/index-footer.php";
?>