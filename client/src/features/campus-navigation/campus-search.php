<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . SHARED . '/form/form-component.php';
require_once ROOT . SERVICES . '/campus-navigation-service.php';

$path = MODALS . '/modal-script.js';
echo "<script src='$path'></script>";

?>
<form class="create-form" id="search-form" method="post" action="#" enctype="multipart/form-data">
    <div class="form-body">
        <div class='form-input'>
            <label for='location'>Level</label>
            <select id='level' name='level' class='select-input'>
                <option value=''>All</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
                <option value='5'>5</option>
                <option value='6'>6</option>
                <option value='7'>7</option>
                <option value='8'>8</option>
                <option value='9'>9</option>
            </select>
        </div>
        <div class='form-input'>
            <label for='type'>Type</label>
            <select id='type' name='type' class='select-input'>
                <option value='' selected>All</option>
                <option value='Classroom'>Show Classroom</option>
                <option value='Auditorium / Lecture Halls'>Show Auditorium / Lecture Halls</option>
                <option value='Labs / Workshops / Studios / Suites'>Show Labs / Workshops / Studios / Suites</option>
                <option value='Other Facilities'>Show Other Facilities</option>
            </select>
        </div>
        <div class='form-input'>
            <label for='location'>Locations</label>
            <select id='location' name='location' class='select-input'>
                <option value='' disabled selected>Select an option</option>
            </select>
        </div>
    </div>
</form>

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

    <div class="campus-btn" onclick="findRoute()">
        <span class="btn-text">
            FIND ROUTE
        </span>
        <?php
        $userPlusIcon = ROOT . ICONS . '/find-route-icon.svg';
        if (file_exists($userPlusIcon)) {
            include_once $userPlusIcon;;
        }
        ?>
    </div>
</form>
