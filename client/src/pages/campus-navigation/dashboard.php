<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
include_once ROOT . COMPONENTS . '/header.php';
include_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . NAVIGATION . '/nav-bar.php';

if (!isset($_SESSION['userID'])) {
    header("Location: " . INDEX);
    exit();
}

// Highlight current page on navigation bar
$_SESSION['currentPage'] = 'directory';

$cssFiles = ["nav-bar.css", "nav-map.css", "form.css"];

createHead("Orbit | User Admin Dashboard", $cssFiles, false);


// Nav Bar and content top bar.
renderNavBar();
?>

<div class="page-content">
    <div class="campus-container">
        <div class="left-side">
            <?php require_once ROOT . FEATURES . '/campus-navigation/campus-search.php'; ?>
        </div>

        <div class="map" id="map">
        </div>
    </div>
</div>
<script src="<?php echo FEATURES ?>/campus-navigation/search-location.js"></script>
<?php
createFooter(false);
?>