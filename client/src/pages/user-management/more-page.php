<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

include_once ROOT . COMPONENTS . '/header.php';
include_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . COMPONENTS . '/admin-nav-bar.php';
require_once ROOT . CONFIG; // Establish connection to database and start session
require_once ROOT . SERVICES . '/manage-user-service.php';
require_once ROOT . MODALS . '/modal.php';

if (!isset($_SESSION['userID'])) {
    header("Location: " . INDEX);
    exit();
}

$user = getUser($_SESSION['userID']); // Get user data of current logged in user

$name = $user['name'];
$role = $user['role'];

// Highlight current page on navigation bar
$_SESSION['currentPage'] = 'more';

$cssFiles = ["admin-dashboard.css", "admin-top-bar.css", 'admin-nav-bar.css'];

createHead("Orbit | More", $cssFiles);

// Profile modal (hidden by default)
$modalObj = new Modal('userProfileView', 'large');
$profileHtml = $modalObj->formatUserProfile($user);
echo $modalObj->render("My Profile", $profileHtml);

// Nav Bar and content top bar.
renderNavBar();
renderContentTopBar($name, $role);
?>
<script src="<?php echo FEATURES . '/modal-script.js'; ?>"></script>
<?php
createFooter(false);
?>