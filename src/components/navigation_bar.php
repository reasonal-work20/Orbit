<?php
$doc_root_folder = $_SERVER['DOCUMENT_ROOT'] . '/Orbit-Captone-Projet';
include_once ($doc_root_folder . '/src/config/config.php');

function renderNavItem($name, $iconPath, $linkUrl, $pageId) {
    $baseUrl = '/Orbit-Captone-Projet';

    global $current_page;

    $iconPath = $iconPath . '?version=' . time();

    $activeClass = ($current_page == $pageId) ? 'active' : '';

    echo "
    <li class='nav-item' {$activeClass}>
        <a href='{$linkUrl}' class='nav-link'>
            <img class='nav-item-icon' src='{$baseUrl}{$iconPath}' aria-hidden='true'>
            <div class='nav-label'>{$name}</div>
        </a>
    </li>
    ";
}

$current_page = 'home'
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/styles/navigation_bar.css?version=<?php echo time(); ?>">
    <title>Navigation Bar</title>
</head>
<body>
    <div class="nav-bar">
        <div class="logo-wrapper">
            <img class='logo'src="<?php echo BASE_URL . 'src/resources/icons/orbit-logo.svg'?>">
        </div>
        <div class="nav-button-container">
            <ul class="nav-list" style="list-style: none;">
                <?php
                    renderNavItem('Home', '/src/resources/icons/home-icon.svg', '#', 'home');
                    renderNavItem('Transport', '/src/resources/icons/car-icon.svg', '#', 'transport');
                    renderNavItem('Directory', '/src/resources/icons/map-icon.svg', '#', 'directory');
                    renderNavItem('Profile', '/src/resources/icons/profile-icon.svg', '#', 'profile');
                    renderNavItem('More', '/src/resources/icons/more-icon-vertical.svg', '#', 'more');
                ?>
            </ul>
        </div>
    </div>
</body>
</html>