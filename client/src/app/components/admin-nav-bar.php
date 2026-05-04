<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

function renderNavItem($name, $iconFilename, $link, $pageId)
{
    $svgPath = ROOT . ICONS . "/{$iconFilename}";

    $activeClass = (isset($_SESSION['currentPage']) && $_SESSION['currentPage'] == $pageId) ? 'active' : '';

    echo "<li class='nav-item {$activeClass} id={$pageId}''></li>";
    echo "<a href='{$link}'>";
    echo "<div class='icon'>";
    if (file_exists($svgPath)) {
        include $svgPath;
    }
    echo "</div>";
    echo "<span>{$name}</span>";
    echo "</a>";
    echo "</li>";
}

function renderNavBar()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userRole = $_SESSION['userRole'] ?? 'guest';

    echo '<div class="nav-bar">';
    echo '<div class="nav-container">';
    echo '<div class="logo-wrapper">';
    echo '<img class="logo" src="' . ASSETS . '/icons/orbit-logo.svg">';
    echo '</div>';
    echo '<ul class="nav-list" style="list-style: none;">';
    switch ($userRole) {
        case 'User Admin':
            $dashboardPath = PAGES . "/{$userRole}/dashboard.php";
            renderNavItem('Home', 'home-icon.svg', $dashboardPath, 'home');
            renderNavItem('Directory', 'map-icon.svg', '#', 'directory');
            renderNavItem('Manage Users', 'calendar-icon.svg', '#', 'manageusers');
            renderNavItem('More', 'more-icon-vertical.svg', '#', 'more');
            break;
        case 'Course Admin':
            $dashboardPath = PAGES . "/{$userRole}/dashboard.php";
            renderNavItem('Home', 'home-icon.svg', $dashboardPath, 'home');
            renderNavItem('Directory', 'map-icon.svg', '#', 'directory');
            renderNavItem('Manage Course', 'calendar-icon.svg', '#', 'managecourses');
            renderNavItem('More', 'more-icon-vertical.svg', '#', 'more');
            break;
        case 'Schedule Admin':
            $dashboardPath = PAGES . "/{$userRole}/dashboard.php";
            renderNavItem('Home', 'home-icon.svg', $dashboardPath, 'home');
            renderNavItem('Directory', 'map-icon.svg', '#', 'directory');
            renderNavItem('Manage Schedules', 'calendar-icon.svg', '#', 'manageschedules');
            renderNavItem('More', 'more-icon-vertical.svg', '#', 'more');
            break;
        default:
            renderNavItem('Log In', 'login-square-icon.svg', APP . '/login-page.php', 'login');
    }

    echo '</ul>';
    renderNavItem('Log Out', 'login-square-icon.svg', APP . '/login-page.php', 'login');
    echo '</div>';
    echo '</div>';
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="nav-bar">
        <div class="logo-wrapper">
            <img class="logo" src="<?php echo ASSETS . '/icons/orbit-logo.svg'?>">
        </div>
        <div class="nav-wrapper">
            <ul class="nav-list">
                <?php
                renderNavItem('Home', 'home-icon.svg', '#', 'home');
                renderNavItem('Directory', 'map-icon.svg', '#', 'directory');
                renderNavItem('Manage Users', 'calendar-icon.svg', '#', 'manageusers');
                renderNavItem('More',  'more-icon-vertical.svg', '#', 'more');
                ?>
            </ul>
        </div>
        <?php renderNavItem('Log Out', 'login-square-icon.svg', '#', 'more'); ?>
    </div>
</body>

</html>