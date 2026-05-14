<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
include_once ROOT . COMPONENTS . '/header.php';
include_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . NAVIGATION . '/nav-bar.php';
require_once ROOT . SERVICES . '/campus-navigation-service.php';
require_once ROOT . FEATURES . '/campus-navigation/campus-search.php';
require_once ROOT . MODALS . '/modal.php';

if (!isset($_SESSION['userID'])) {
    header("Location: " . INDEX);
    exit();
}

// Highlight current page on navigation bar
$_SESSION['currentPage'] = 'directory';

$cssFiles = ["nav-bar.css", "nav-map.css", "form.css"];

createHead("Orbit | User Admin Dashboard", $cssFiles, false);

$searchFormContent = getSearchFormContent("searchCampus");
$searchFormModal = new Modal('searchCampus', 'medium');
echo $searchFormModal->render("Search Location on Campus", $searchFormContent);

$routeContent = getRouteContent("findRoute");
$routeModal = new Modal('findRoute', 'medium');
echo $routeModal->render("Find Route", $routeContent);

// Nav Bar and content top bar.
renderNavBar();
?>

<div class="page-content">
    <div class="campus-container">
        <div class="map">
            <?php
            if (isset($_SESSION["map"])) {
                $mapList = $_SESSION["map"]["svg"];
                foreach ($mapList as $map) {
                    echo $map;
                }
            }
            ?>
        </div>
    </div>
</div>
<script src="<?php echo FEATURES ?>/campus-navigation/search-location.js"></script>
<?php
createFooter(false);
?>