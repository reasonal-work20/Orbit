<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

$page = $_GET['page'];
switch ($page) {
    case "login":
        $path = PAGES . '/login/login-page.php';
        break;
    case "userAdmin":
        $path = PAGES . '/user-management/dashboard.php';
        break;
}
header("Location: " . $path);
?>