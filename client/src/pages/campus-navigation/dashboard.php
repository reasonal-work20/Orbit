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
createHead("Orbit | Campus Navigation", $cssFiles, false);


// Nav Bar and content top bar.
renderNavBar();
?>

<div class="page-content">
    <div class="campus-container">
        <div class="left-side">
            <?php require_once ROOT . FEATURES . '/campus-navigation/campus-search.php'; ?>
        </div>

        <div class="map" id="mapFrame">
            <div id="map"></div>
        </div>
    </div>
</div>
<script src="<?php echo FEATURES ?>/campus-navigation/search-location.js"></script>
<?php
createFooter(false);
if (isset($_GET['point'])) {
    $point = $_GET['point'];
    echo "<script>
        window.onload = function() {
            const locationInput = document.getElementById('location');
            setTimeout (function() {
                if (locationInput) {
                    locationInput.value = '$point' ;
                    document.getElementById('end').value = '$point';
                    locationInput.dispatchEvent(new Event('change'));
                }
            }, 100);
        };
    </script>";
}

?>