<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

function renderNavItem($name, $iconFilename, $link, $pageId)
{
    $svgPath = ROOT.ASSETS . '/icons/' . $iconFilename;

    $activeClass = (isset($_SESSION['currentPage']) && $_SESSION['currentPage'] == $pageId) ? 'active' : '';

    echo "<li class='nav-item {$activeClass}' id='{$pageId}'>";
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
    // Ensure session is started to check roles
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userRole = $_SESSION['user_role'] ?? 'guest';

    echo '<div class="nav-bar">';
    echo '<div class="nav-container">';
    echo '<div class="logo-wrapper">';
    echo '<img class="logo" src="' . ASSETS . '/icons/orbit-logo.svg">';
    echo '</div>';
    echo '<ul class="nav-list" style="list-style: none;">';

    switch ($userRole) {
        case 'student':
            renderNavItem('Home', 'home-icon.svg', '#', 'home');
            renderNavItem('Transport', 'car-icon.svg', '#', 'transport');
            renderNavItem('Directory', 'map-icon.svg', '#', 'directory');
            renderNavItem('Timetable', 'calendar-icon.svg', '#', 'timetable');
            renderNavItem('More', 'more-icon-vertical.svg', '#', 'more');
            break;

        case 'lecturer':
        case 'admin1':
        case 'admin2':
        case 'admin3':
            // These roles share the same primary navigation structure in your logic
            $dashboardPath = PAGES . "/{$userRole}/dashboard.php";
            renderNavItem('Home', 'home-icon.svg', $dashboardPath, 'home');
            renderNavItem('Directory', 'map-icon.svg', '#', 'directory');
            renderNavItem('Timetable', 'calendar-icon.svg', '#', 'timetable');
            renderNavItem('More', 'more-icon-vertical.svg', '#', 'more');
            break;

        default:
            renderNavItem('Log In', 'login-square-icon.svg', APP . '/login-page.php', 'login');
            break;
    }

    echo '</ul>';
    echo '</div>';
    echo '</div>';
}
?>