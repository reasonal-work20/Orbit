<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.ROUTES.'/login.php';

$data = $_POST;
$result = login($data);
if ($result["error"]) {
    $_SESSION['loginError'] = $result["message"]; // Displays message to login page
    header("Location: " . SHARED . "/login-page.php");
} else {
    switch ($_SESSION['role']) {
        case 'User Admin':
            header("Location: " . APP . "/user-admin-dashboard.php");
            break;
        case 'Course Admin':
            header("Location: " . APP . "/course-admin-dashboard.php");
            break;
        case 'Schedule Admin':
            header("Location: " . APP . "/schedule-admin-dashboard.php");
            break;
        default:
            header("Location: " . APP . "/home.php");
    }
    /**
     * $_SESSION['userID'] already set.
     * $_SESSION['role'] already set.
     * 
     * Roles Output:
     * User Admin
     * Course Admin
     * Schedule Admin
     */
}
?>