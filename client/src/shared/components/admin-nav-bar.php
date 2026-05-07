<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

function renderNavItem($name, $iconFilename, $link, $pageId)
{
    $svgPath = ROOT . ICONS . "/{$iconFilename}";

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
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userRole = $_SESSION['userRole'] ?? 'guest';

    echo '<div class="nav-bar">';
    
    echo '<div class="logo-wrapper">';
    echo '<img class="logo" src="' . ASSETS . '/icons/orbit-logo.svg" alt="Orbit Logo">';
    echo '</div>';

    echo '<div class="nav-wrapper">';
    echo '<ul class="nav-list">';
    
    switch ($userRole) {
        case 'User Admin':
            $dashboardPath = PAGES . "/{$userRole}/dashboard.php";
            renderNavItem('Home', 'home-icon.svg', $dashboardPath, 'home');
            renderNavItem('Manage Users', 'calendar-icon.svg', '#', 'manageusers');
            renderNavItem('More', 'more-icon-vertical.svg', '#', 'more');
            break;
            
        case 'Course Admin':
            $dashboardPath = PAGES . "/{$userRole}/dashboard.php";
            renderNavItem('Home', 'home-icon.svg', $dashboardPath, 'home');
            renderNavItem('Manage Course', 'calendar-icon.svg', '#', 'managecourses');
            renderNavItem('More', 'more-icon-vertical.svg', '#', 'more');
            break;
            
        case 'Schedule Admin':
            $dashboardPath = PAGES . "/{$userRole}/dashboard.php";
            renderNavItem('Home', 'home-icon.svg', $dashboardPath, 'home');
            renderNavItem('Manage Schedules', 'calendar-icon.svg', '#', 'manageschedules');
            renderNavItem('More', 'more-icon-vertical.svg', '#', 'more');
            break;
            
        default:
            renderNavItem('Log In', 'login-square-icon.svg', APP . '/login-page.php', 'login');
            break;
    }
    echo '</ul>';
    echo '</div>';

    if ($userRole !== 'guest') {
        echo '<ul class="nav-list logout-section">';
        renderNavItem('Log Out', 'logout-square-icon.svg', SERVICES . '/logout-service.php', 'logout');
        echo '</ul>';
    }

    echo '</div>';
}

?>
