<?php
/**
 * Entry point for testing.
*/

session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

// include ROOT.CONFIG;

include_once ROOT.COMPONENTS . "/header.php";
include_once ROOT.COMPONENTS . "/footer.php";
include_once ROOT.COMPONENTS . "/admin-nav-bar.php";
$currentPage = 'home'; // Change this to test different active states
$_SESSION['currentPage'] = $currentPage; // Set the current page for active state testing

$userRole = 'User Admin'; // Change this to test different roles
$_SESSION['userRole'] = $userRole; // Set the user role in session for testing

createHead('Test Page', ['global.css', 'admin-nav-bar.css']);
?>

<script src="<?php echo FEATURES . '/ripple-effect.js'; ?>"></script>
<?php renderNavBar(); ?>
<?php 
createFooter(false);
?>