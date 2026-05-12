<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

include_once ROOT . COMPONENTS . '/header.php';
include_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . NAVIGATION . '/admin-nav-bar.php';
require_once ROOT . SERVICES . '/manage-user-service.php';

if (!isset($_SESSION['userID'])) {
    header("Location: " . INDEX);
    exit();
}

$user = getUser($_SESSION['userID']);
$name = $user['name'];
$role = $user['role'];

// Highlight current page on navigation bar
$_SESSION['currentPage'] = 'home';

$cssFiles = ["admin-top-bar.css", "admin-dashboard.css", 'admin-nav-bar.css'];

createHead("Orbit | User Admin Dashboard", $cssFiles);

// Nav Bar and content top bar.
renderNavBar();
renderContentTopBar($name, $role);
?>

<?php
createFooter(false);
?>