<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . ROUTES . '/login.php';

$data = $_POST;
$result = login($data);
if ($result["error"]) {
    $_SESSION['error'] = $result["message"]; // Displays message to login page
    $path = PAGES . "/login/login-page.php";
} else {
    switch ($_SESSION['role']) {
        case 'User Admin':
            $path = APP . "userAdmin";
            break;
        case 'Course Admin':
            $path = APP . "courseAdmin";
            break;
        case 'Schedule Admin':
            $path = APP . "scheduleAdmin";
            break;
        case 'Student':
            $path = APP . "dashboard";
            break;
        case 'Lecturer':
            $path = APP . "dashboard";
            break;
        default:
            $path = INDEX;
    }
}
header("Location: " . $path);
?>