<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . SERVICES . '/manage-user-service.php';
require_once ROOT . MODALS . '/modal.php';
require_once ROOT . COMPONENTS . '/header.php';
require_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . NAVIGATION . '/nav-bar.php'; 
require_once ROOT . SHARED . '/form/form-component.php'; 
require_once ROOT . COMPONENTS . '/settings-card.php';

if (!isset($_SESSION['userID'])) {
    header("Location: " . INDEX);
    exit();
}

if (!isset($user) || empty($user)) {
    $user = getUser($_SESSION['userID']); // Get user data of current logged in user
}

$name = $user['name'];
$role = $user['role'];

// Highlight current page on navigation bar
$_SESSION['currentPage'] = '';

$cssFiles = ["global.css", 'nav-bar.css', 'modal.css', 'user-settings-page.css'];

createHead("Orbit | Settings", $cssFiles);

// Nav Bar and content top bar.
renderNavBar();
?>
<!-- Content here -->
<div class="page-content">

    <?php renderUserSettingsCard() ?>

</div>
<script src="<?php echo FEATURES . '/create-user-form.js'; ?>"></script>
<script src="<?php echo PAGES . '/more/settings-script.js'; ?>"></script>

<?php
createFooter(false);
?>