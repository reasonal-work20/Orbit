<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONFIG;
require_once ROOT . CONTROLLERS . '/manage-module.php';
require_once ROOT . CONTROLLERS . '/manage-intake.php';

$manageModule = new ManageCourse();
$manageIntake = new ManageIntake();

function getMajorList() {
    global $manageModule;
    $tempList = $manageModule->getMajorList();
    $majorList = [];
    foreach ($tempList as $row) {
        $majorList[$row["majorID"]] = $row["name"];
    }
    return $majorList;
}

function getModuleList($majorID){
    global $manageModule;
    return $manageModule->getModuleList($majorID);
}

function createModule($input) {
    global $manageModule;
    return $manageModule->createModule($input);
}

function updateModule($input) {
    global $manageModule;
    return $manageModule->updateModule($input);
}

function deleteModule($moduleID) {
    global $manageModule;
    return $manageModule->deleteModule($moduleID);
}

function getCourseList() {
    global $manageIntake;
    return $manageIntake->getCourseType();
}

function getIntakeList($search) {
    global $manageIntake;
    return $manageIntake->getIntakeList($search);
}

function getIntake($intakeID) {
    global $manageIntake;
    return $manageIntake->getIntake($intakeID);
}

function createIntake($input) {
    global $manageIntake;
    return $manageIntake->createIntake($input);
}

function updateIntake($input) {
    global $manageIntake;
    return $manageIntake->updateIntake($input);
}

function deleteIntake($intakeID) {
    global $manageIntake;
    return $manageIntake->deleteIntake($intakeID);
}
?>