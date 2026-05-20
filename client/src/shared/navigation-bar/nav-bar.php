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
    // Ensure session is started to check roles
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    echo '<div class="nav-bar">';
    echo '<div class="nav-container">';
    echo '<div class="logo-wrapper">';
    echo '<img class="logo" src="' . ASSETS . '/icons/orbit-logo.svg">';
    echo '</div>';
    echo '<ul class="nav-list" style="list-style: none;">';

    renderNavItem('Home', 'home-icon.svg', APP . 'dashboard', 'home');
    renderNavItem('Transport', 'car-icon.svg', APP . 'transport', 'transport');
    renderNavItem('Directory', 'map-icon.svg', APP . "directory", 'directory');
    renderNavItem('Timetable', 'calendar-icon.svg', '#', 'timetable');
    renderNavItem('More', 'more-icon-vertical.svg', APP . 'more', 'more');

    echo '</ul>';
    echo '</div>';
    echo '</div>';
}
