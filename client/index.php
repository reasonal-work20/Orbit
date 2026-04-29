<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

// Include the header

include_once ROOT.COMPONENTS . "/header.php";
include_once ROOT.COMPONENTS . "/footer.php";

$indexPage = true;
$cssFiles = ['global.css', 'landing-page.css'];
createHead('Orbit', $cssFiles)

?>

<img id='orbit-logo' src="<?php echo ASSETS; ?>/icons/orbit-logo.svg" alt="orbit logo" aria-hidden="true">
        <p class="title">
            Your personal campus navigator and transport manager
        </p>
        <div class="login-button">
            <a href="<?php echo APP; ?>/login-page.php">Log In
                <div class="icon">
                    <?php include_once ROOT.ASSETS . "/icons/login-square-icon.svg" ?>
                </div>
            </a>
        </div>

<?php
createFooter($indexPage);
?>