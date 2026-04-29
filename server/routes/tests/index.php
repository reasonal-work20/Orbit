<?php
/**
 * Entry point for testing.
*/

session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

// include ROOT.CONFIG;

include_once ROOT.COMPONENTS . "/header.php";
include_once ROOT.COMPONENTS . "/footer.php";
include_once ROOT.COMPONENTS . "/nav-bar.php";

$currentPage = 'home';
$_SESSION['currentPage'] = $currentPage; // Set the current page for active state testing
$userRole = 'student'; // Change this to test different roles
$_SESSION['user_role'] = $userRole; // Set the user role in session for testing

createHead('Test Page', ['global.css', 'test-page.css', 'nav-bar.css']);
renderNavBar();
?>

<script src="<?php echo FEATURES . '/ripple-effect.js'; ?>"></script>

<?php 
createFooter(false);
?>