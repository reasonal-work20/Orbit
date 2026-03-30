<?php
$doc_root_folder = $_SERVER['DOCUMENT_ROOT'] . '/Orbit';
include_once($doc_root_folder . '/src/config/config.php');

function renderNavItem($name, $iconPath, $linkUrl, $pageId)
{

    global $current_page;

    $iconPath = $iconPath . '?version=' . time();

    $activeClass = ($current_page == $pageId) ? 'active' : '';

    echo "
    <li class='nav-item {$activeClass}' id='{$pageId}'>
        <a href='{$linkUrl}'>
            <div class='nav-link'>
                <img class='nav-item-icon' src='". BASE_URL . "{$iconPath}' aria-hidden='true'>
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
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/styles/navigation_bar.css?version=<?php echo time(); ?>">
    <title>Anonymous Navigation Bar</title>
</head>

<body>
    <div class="nav-bar">
        <div class="nav-container">
            <div class="logo-wrapper">
                <img class='logo' src="<?php echo BASE_URL . 'src/resources/icons/orbit-logo.svg' ?>">
            </div>
            <div class="nav-button-container">
                <ul class="nav-list" style="list-style: none;">
                    <?php
                    renderNavItem('Home', '/src/resources/icons/home-icon.svg', '#', 'home');
                    renderNavItem('Login', '/src/resources/icons/login-square-icon.svg', '#', 'login');
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>