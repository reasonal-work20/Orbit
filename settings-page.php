<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';


require_once ROOT . CONFIG; // Establish connection to database and start session
require_once ROOT . SERVICES . '/manage-user-service.php';
require_once ROOT . MODALS . '/modal.php';
require_once ROOT . COMPONENTS . '/header.php';
require_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . COMPONENTS . '/admin-nav-bar.php'; // Admin nav bar components
require_once ROOT . COMPONENTS . '/manage-user-components.php'; // Manage user components (For the form)
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

$cssFiles = ["global.css", "admin-top-bar.css", 'admin-nav-bar.css', 'modal.css', 'settings-page.css'];

createHead("Orbit | Settings", $cssFiles);

// Profile modal (hidden by default)
$modalObj = new Modal('userProfileView', 'large');
$profileHtml = $modalObj->formatUserProfile($user);
echo $modalObj->render("My Profile", $profileHtml);

// Nav Bar and content top bar.
renderNavBar();
renderContentTopBar($name, $role);
?>
<!-- Content here -->
<div class="page-content">

    <?php renderAdminSettingsCard() ?>

</div>
<script src="<?php echo FEATURES . '/modal-script.js'; ?>"></script>
<script src="<?php echo FEATURES . '/create-user-form.js'; ?>"></script>
<script src="<?php echo FEATURES . '/settings-script.js'; ?>"></script>
<?php
createFooter(false);
?>