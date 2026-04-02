<?php
$doc_root_folder = $_SERVER['DOCUMENT_ROOT'] . '/Orbit';
include_once($doc_root_folder . '/src/config/config.php');
?>
<!-- Home Page For Anonymous Users -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/src/styles/global.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/styles/anon.css?version<?php echo time() ?>">
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>src/resources/icons/orbit-logo-square.svg?version=<?php echo time(); ?>">
    <title>Orbit</title>
</head>

<body>
    <div class="content-container">
        <img id='orbit-logo' src="<?php echo BASE_URL; ?>/src/resources/icons/orbit-logo.svg" alt="orbit logo" aria-hidden="true">
        <p class="title">
            Your personal campus navigator and transport manager
        </p>
        <div class="login-button">
            <a href="<?php echo BASE_URL; ?>/src/app/login/login_page.php">Log In
                <div class="icon">
                    <?php include_once $doc_root_folder . "/src/resources/icons/login-square-icon.svg" ?>
                </div>
            </a>
        </div>
    </div>
    <div class="footer">
        <p class="footer-text">an extension of</p>
        <img id="apspace-logo" src="<?php echo BASE_URL; ?>/src/resources/icons/apspace-logo.svg" alt="apspace logo" aria-hidden="true">
        <p class="footer-text"> ORBIT &copy; 2026</p>
    </div>
</body>

</html>