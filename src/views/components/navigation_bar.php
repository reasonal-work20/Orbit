<?php
$doc_root_folder = $_SERVER['DOCUMENT_ROOT'] . '/Orbit';
include_once($doc_root_folder . '/config/config.php');

function renderNavItem($name, $iconFilename, $linkUrl, $pageId)
{
    
    $doc_root_folder = $_SERVER['DOCUMENT_ROOT'] . '/Orbit';
    $svgPath = $_SERVER['DOCUMENT_ROOT'] . ASSETS_PATH . '/icons/' . $iconFilename;
    $activeClass = (isset($_SESSION['current_page']) && $_SESSION['current_page'] == $pageId) ? 'active' : '';

    echo "
    <li class='nav-item {$activeClass}' id='{$pageId}'>
        <a href='{$linkUrl}'>
            <div class='nav-link'>
                <div class='icon'>
    ";

    if (file_exists($svgPath)) {
        include $svgPath;
    } else {
        echo "";
    }

    echo "
                </div>
                {$name}
             </div>
        </a>
    </li>
    ";
}
?>


<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH; ?>/styles/global.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH; ?>/styles/navigation_bar.css?version=<?php echo time(); ?>">
    <title>Navigation Bar</title>
</head>

<body>
    <div class="nav-bar">
        <div class="nav-container">
            <div class="logo-wrapper">
                <img class='logo' src="<?php echo ASSETS_PATH . '   /icons/orbit-logo.svg' ?>">
            </div>
            <ul class="nav-list" style="list-style: none;">
                <?php
                renderNavItem('Home', 'home-icon.svg', 'dashboard.php', 'home');
                renderNavItem('Transport', 'car-icon.svg', '#', 'transport');
                renderNavItem('Directory', 'map-icon.svg', '#', 'directory');
                renderNavItem('Profile', 'profile-icon.svg', '#', 'profile');
                renderNavItem('More', 'more-icon-vertical.svg', '#', 'more');
                ?>
            </ul>
        </div>
    </div>
</body>

</html>