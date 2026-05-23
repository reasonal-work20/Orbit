<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONTROLLERS . '/schedule-controller.php';
require_once ROOT . CONTROLLERS . '/manage-intake.php';
require_once ROOT . CONTROLLERS . '/manage-course-module.php';

$scheduleController = new ScheduleController();
$manageIntake = new ManageIntake();
$manageCourseModule = new ManageCourseModule();

function getModuleGroup($intakeID) {
    global $manageCourseModule, $manageIntake;
    if ($intakeID === "All") {  
        $intakeList = $manageIntake->getIntakeList("");
    } else {
        $intakeList = [["intakeID" => $intakeID]];
    }
    $result = [];
    foreach ($intakeList as $intake) {
        $courseModuleList = $manageCourseModule->getList($intake['intakeID']);
        foreach ($courseModuleList as $courseModule) {
            foreach ($courseModule['group'] as $group) {
                $result[$group['moduleGroupID']] = $group['moduleGroupID'];
            }
        }
    }
    return $result;
}

function getClassrooms() {
    global $scheduleController;
    return $scheduleController->getClassrooms();
}

function getIntake() {
    global $manageIntake;
    return $manageIntake->getIntakeList("");
}

function getWeeks() {
    global $scheduleController;
    return $scheduleController->getWeeks();
}

function getScheduleList($input) {
    global $scheduleController;
    return $scheduleController->getScheduleList($input);
}

function getSchedule($input) {
    global $scheduleController;
    if (!isset($input["scheduleID"])) {
        return "No schedule ID found.";
    }
    return $scheduleController->getSchedule($input['scheduleID']);
}

function createSchedule($input) {
    global $scheduleController;
    return $scheduleController->createSchedule($input);
}

function updateSchedule($input) {
    global $scheduleController;
    return $scheduleController->updateSchedule($input);
}

function deleteSchedule($input) {
    global $scheduleController;
    return $scheduleController->deleteSchedule($input["scheduleID"]);
}
?>