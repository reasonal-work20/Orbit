<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
// COMPONENT SETUP
require_once ROOT . COMPONENTS . '/header.php';
require_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . NAVIGATION . '/nav-bar.php';
require_once ROOT . COMPONENTS . '/more-card.php';
require_once ROOT . COMPONENTS . '/quick-access.php';
require_once ROOT . COMPONENTS . '/settings-card.php';
require_once ROOT . SERVICES . '/manage-user-service.php';
require_once ROOT . MODALS . '/modal.php';

// START CONNECTION TO DB
require_once ROOT . CONFIG;

if (!isset($_SESSION['userID'])) {
    header("Location: " . INDEX);
    exit();
}

if (!isset($user) || empty($user)) {
    $user = getUser($_SESSION['userID']); // Get user data of current logged in user
}

$_SESSION['currentPage'] = 'more';

$cssFiles = ["global.css", "user-dashboard.css", 'nav-bar.css','user-more-page.css', 'modal.css'];

createHead("Orbit | More", $cssFiles);
renderNavBar();

?>
<div class="page-content">
    <?php
    renderUserMoreActionsContainer();
    ?>
</div>

<?php
createFooter(false);
?>