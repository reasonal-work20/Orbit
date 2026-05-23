<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
// COMPONENT SETUP
require_once ROOT . COMPONENTS . '/header.php';
require_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . NAVIGATION . '/nav-bar.php';
require_once ROOT . FEATURES . '/timetable/timetable-page-components.php';
require_once ROOT . SERVICES . '/manage-user-service.php';
require_once ROOT . MODALS . '/modal.php';
require_once ROOT . SERVICES . '/manage-schedule-service.php';

// START CONNECTION TO DB
require_once ROOT . CONFIG;

if (!isset($_SESSION['userID'])) {
    header("Location: " . INDEX);
    exit();
}

if (isset($_GET['week'])) {
    $week = $_GET['week'];
} else {
    $dateTime = new DateTime('Monday this week');
    $week = $dateTime->format("Y-m-d");
}

if (!isset($user) || empty($user)) {
    $user = getUser($_SESSION['userID']); // Get user data of current logged in user
    if ($user['role'] === 'Student') {
        $intakeID = $user['intakeID'];
        $scheduleList = getScheduleList(['intakeID' => $intakeID, "week" => $week]);
    } else {
        $intakeID = "All";
        $tempList = getScheduleList(['intakeID' => $intakeID, "week" => $week]);
        $scheduleList = [];
        foreach ($tempList as $row) {
            $schedule = getSchedule($row);
            if ($schedule['lecturerID'] === $user['lecturerID']) {
                $scheduleList[] = $row;
            }
        }
    }
}



$_SESSION['currentPage'] = 'timetable';

$cssFiles = ["global.css", "user-dashboard.css", 'timetable-page.css', 'nav-bar.css', 'modal.css', 'quick-access.css', 'bus-shuttle.css', 'form.css'];

createHead("Orbit | Timetable", $cssFiles);
renderNavBar();

?>
<div class="page-content">
    <?php
    if ($week === "All") {
        $select = "selected";
    } else {
        $select = "";
    }
    echo "
        <div class='form-input'>
            <select id='selectWeek' name='selectWeek' class='select-input'>
            <option value='' selected disabled>Select Week</option>
            <option value='All' $select>All</option>";
        $weekList = getWeeks();
        foreach ($weekList as $monday) {
            if ($monday === $week) {
                $select = "selected";
            } else {
                $select = "";
            }
            $format = date("M j, Y", strtotime($monday));
            echo "<option value='$monday' $select>$format</option>";
        }
        echo "
            </select>
        </div>
        ";
    renderTimetable($scheduleList);
    ?>
</div>

<script>
    document.getElementById('selectWeek').addEventListener("change", function (event) {
        let week = this.value;
        window.location.href=`/Orbit/client/src/pages/timetable/dashboard.php?week=${week}`;
    });
</script>

<?php
createFooter(false);
?>