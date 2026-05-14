<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
include_once ROOT . COMPONENTS . '/header.php';
include_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . NAVIGATION . '/nav-bar.php';

if (!isset($_SESSION['userID'])) {
    header("Location: " . INDEX);
    exit();
}

// Highlight current page on navigation bar
$_SESSION['currentPage'] = 'transport';
$cssFiles = ["nav-bar.css", "form.css"];
createHead("Orbit | Campus Navigation", $cssFiles, false);


// Nav Bar and content top bar.
renderNavBar();
?>

<div class="page-content">
</div>

<?php
createFooter(false);
?>