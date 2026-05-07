<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.ROUTES.'/login.php';

$data = $_POST;
$result = login($data);
if ($result["error"]) {
    $_SESSION['loginError'] = $result["message"]; // Displays message to login page
    header("Location: " . APP . "/login-page.php");
} else {
    switch ($_SESSION['role']) {
        case 'User Admin':
            header("Location: " . PAGES . "/user-admin-dashboard.php");
            break;
        case 'Course Admin':
            header("Location: " . PAGES . "/course-admin-dashboard.php");
            break;
        case 'Schedule Admin':
            header("Location: " . PAGES . "/schedule-admin-dashboard.php");
            break;
        case 'Student':
            header("Location: " . FEATURES . "/transport/transport.php");
            break;
        default:
            header("Location: " . PAGES . "/home.php");
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