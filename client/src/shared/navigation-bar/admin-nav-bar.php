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
    // echo $_SESSION['role']; // Testing user role
    $userRole = $_SESSION['role'] ?? 'guest';

    echo '<div class="nav-bar">';
    
    echo '<div class="logo-wrapper">';
    echo '<img class="logo" src="' . ASSETS . '/icons/orbit-logo.svg" alt="Orbit Logo">';
    echo '</div>';

    echo '<div class="nav-wrapper">';
    echo '<ul class="nav-list">';
    
    switch ($userRole) {
        case 'User Admin':
            $dashboardPath = PAGES . "/user-management/dashboard.php";
            $manageUsersPath = PAGES . "/user-management/dashboard.php";
            $morePath = PAGES . "/user-management/more-page.php";
            renderNavItem('Home', 'home-icon.svg', $dashboardPath, 'home');
            renderNavItem('Manage Users', 'manage-users-icon.svg', $manageUsersPath, 'manageusers');
            renderNavItem('More', 'more-icon-vertical.svg', $morePath, 'more');
            break;
            
        case 'Course Admin':
            $dashboardPath = PAGES . "/course-management/dashboard.php";
            renderNavItem('Home', 'home-icon.svg', $dashboardPath, 'home');
            renderNavItem('Manage Course', 'calendar-icon.svg', '#', 'managecourses');
            renderNavItem('More', 'more-icon-vertical.svg', '#', 'more');
            break;
            
        case 'Schedule Admin':
            $dashboardPath = PAGES . "/course-management/dashboard.php";
            renderNavItem('Home', 'home-icon.svg', $dashboardPath, 'home');
            renderNavItem('Manage Schedules', 'calendar-icon.svg', '#', 'manageschedules');
            renderNavItem('More', 'more-icon-vertical.svg', '#', 'more');
            break;
            
        default:
            renderNavItem('Log In', 'login-square-icon.svg', PAGES . '/login/login-page.php', 'login');
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

function renderContentTopBar($name, $role, $profileImg = UPLOADS . '/default-profile.png') {
    echo '<div class="top-bar">';
    echo '<div class="profile" onClick="openModal(\'userProfileView\')">';
    echo '<div class="name-and-role">';
    echo '<span class="username">' . htmlspecialchars($name) . '</span>';
    echo '<span class="role">' . htmlspecialchars($role) . '</span>';
    echo '</div>';
    echo '<div class="profile-img-container">';
    echo '<img src="' . $profileImg . '" alt="Profile Image" class="profile-img">';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

?>