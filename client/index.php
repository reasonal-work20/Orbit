<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.ASSETS;
require_once ROOT.COMPONENTS;

// Include the header

include_once COMPONENTS . "/index-header.php";

?>

<img id='orbit-logo' src="<?php echo BASE_URL; ?>/src/resources/icons/orbit-logo.svg" alt="orbit logo" aria-hidden="true">
        <p class="title">
            Your personal campus navigator and transport manager
        </p>
        <div class="login-button">
            <a href="<?php echo BASE_URL; ?>/src/app/auth/login_page.php">Log In
                <div class="icon">
                    <?php include_once $doc_root_folder . "/src/resources/icons/login-square-icon.svg" ?>
                </div>
            </a>
        </div>

<?php
include_once COMPONENTS . "/index-footer.php";
?>