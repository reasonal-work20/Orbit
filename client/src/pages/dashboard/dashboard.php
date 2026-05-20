<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
// COMPONENT SETUP
require_once ROOT . COMPONENTS . '/header.php';
require_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . NAVIGATION . '/nav-bar.php';
require_once ROOT . COMPONENTS . '/quick-access.php';
// require_once ROOT . COMPONENTS . '/timetable-card.php';
require_once ROOT . COMPONENTS . '/user-profile-card.php';
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

$role = $user['role'];

// Initialize current time (For Bus Shuttle)
date_default_timezone_set('Asia/Kuala_Lumpur');
$currentTime = time();

// CHANGE THIS FOR EACH DIFFERENT PAGE!
$_SESSION['currentPage'] = 'home';

$cssFiles = ["global.css",  "timetable-card.css", "profile-card.css", "user-dashboard.css", 'modal.css', 'user-quick-access.css', 'bus-shuttle.css', 'nav-bar.css'];

createHead("Orbit | Dashboard", $cssFiles);

renderNavBar();

?>
<div class="page-content">
    <?php
    renderUserProfileCard($user);
    renderQuickAccessCard($role);
    ?>
    <div class="card-wrapper">
        <?php
        // renderTimetableCardForDashboard(['Class Array -> Belonging to the student`s course and lesson'], $currentTime);
        ?>
    </div>
</div>
<script src="<?php echo FEATURES . '/timetable-script.js'; ?>"></script>
<?php
createFooter(false);
?>