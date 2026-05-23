<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . ROUTES . '/schedule-management-route.php';

if (isset($_POST['addSchedule'])) {
    $date = $_POST['date'];
    $tempStartTime = $_POST['startTime'];
    $tempEndTime = $_POST['endTime'];
    $_POST['startTime'] = $date . " " . $tempStartTime . ":00";
    $_POST['endTime'] = $date . " " . $tempEndTime . ":00";
    $error = createSchedule($_POST);
    $error = "";
    if ($error) {
        $_SESSION['error'] = $error;
    } 
    if ($_POST['intakeID'] === $_POST['week']) {
        $path = PAGES . '/schedule-management/dashboard.php';
    } else {
        $intakeID = $_POST['intakeID'];
        $week = $_POST['week'];
        $path = PAGES . "/schedule-management/dashboard.php?intakeID=$intakeID&week=$week";
    }
    echo "<script>window.location.href='$path';</script>";
}

if (isset($_POST['deleteSchedule'])) {
    $error = deleteSchedule($_POST);
    if ($error) {
        $_SESSION['error'] = $error;
    }
    if ($_POST['intakeID'] === $_POST['week']) {
        $path = PAGES . '/schedule-management/dashboard.php';
    } else {
        $intakeID = $_POST['intakeID'];
        $week = $_POST['week'];
        $path = PAGES . "/schedule-management/dashboard.php?intakeID=$intakeID&week=$week";
    }
    echo "<script>window.location.href='$path';</script>";
}
?>