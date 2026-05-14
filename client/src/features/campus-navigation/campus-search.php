<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . SHARED . '/form/form-component.php';
require_once ROOT . SERVICES . '/campus-navigation-service.php';

$path = MODALS . '/modal-script.js';
echo "<script src='$path'></script>";

function getSearchFormContent($modalName) {
    ob_start();
?>
    <form class="create-form" id="search-form" method="post" action="#" enctype="multipart/form-data">
        <div class="form-body">
            <?php
            renderFormSelect("level", "Level", [
                "3" => "Level 3",
                "4" => "Level 4",
                "5" => "Level 5",
                "6" => "Level 6",
                "7" => "Level 7",
                "8" => "Level 8",
                "9" => "Level 9"
            ], "select-input", false);
            renderFormSelect("type", "Type", [
                "Classroom" => "Show Classrooms",
                "Auditorium / Lecture Halls" => "Show Auditorium",
                "Labs / Workshops / Studios / Suites" => "Show Labs / Workshops / Studios / Suites",
                "Other Facilities" => "Show Other Facilities"
            ], "select-input", false);
            ?>
        </div>

        <div class="form-body" id="locationResult">
        </div>
    </form>
    <?php
    return ob_get_clean();
}


function getRouteContent($modalName) {
    ob_start();
?>
    <form class="create-form" id="find-form" method="get" action="<?php echo PAGES . '/campus-navigation/dashboard.php' ?>" enctype="multipart/form-data">
        <div class="form-body">
            <?php
            $locationList = getLocation(["floor" => "", "type" => ""]);
            $options = [];
            foreach ($locationList as $row) {
                $options[$row['locationID']] = $row['name'];
            }
            renderFormSelect("start", "Starting Location", $options, "select-input");
            renderFormSelect("end", "Destination Location", $options, "select-input");
            renderFormSelect("route", "Route Option", [
                "stair" => "Staircase / Elevator",
                "elevator" => "Elevator Only"
            ], "select-input");
            ?>
        </div>

        <div class="form-actions">
            <input type="hidden" name="mode" value="route" />
            <button type="submit" name="getMap" class="confirm-btn">Confirm</button>
        </div>
    </form>
<?php
    return ob_get_clean();
}
?>

