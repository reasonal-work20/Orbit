<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONFIG;
require_once ROOT . CONTROLLERS . '/manage-module.php';
require_once ROOT . CONTROLLERS . '/manage-intake.php';
require_once ROOT . CONTROLLERS . '/manage-user.php';
require_once ROOT . CONTROLLERS . '/manage-course-module.php';

$manageModule = new ManageCourse();
$manageIntake = new ManageIntake();
$manageUser = new ManageUser();
$manageCourseModule = new ManageCourseModule();

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

function getStudentList($input) {
    global $manageIntake;
    return $manageIntake->getStudentList($input);
}

function enrolStudent($input) {
    global $manageIntake;
    return $manageIntake->addStudent($input);
}

function removeStudent($studentIntakeID) {
    global $manageIntake;
    return $manageIntake->deleteStudent($studentIntakeID);
}

function getLecturer() {
    global $manageUser;
    $userList = $manageUser->getList("");
    $lecturerList = [];
    foreach ($userList as $user) {
        if ($user['role'] === 'Lecturer') {
            $lecturer = $manageUser->get($user['userID']);
            $lecturerList[$lecturer['lecturerID']] = $lecturer['lecturerID'] . " | " . $user['name'] . " | " . $lecturer['qualification'];
        }
    }
    return $lecturerList;
}

function getCourseModuleList($intakeID) {
    global $manageCourseModule;
    return $manageCourseModule->getList($intakeID);
}

function getCourseModule($courseModuleID) {
    global $manageCourseModule;
    return $manageCourseModule->getCourseModule($courseModuleID);
}

function addCourseModule($input) {
    global $manageCourseModule;
    return $manageCourseModule->createCourseModule($input);
}

function editCourseModule($input) {
    global $manageCourseModule;
    return $manageCourseModule->updateCourseModule($input);
}

function deleteCourseModule($input) {
    global $manageCourseModule;
    return $manageCourseModule->deleteCourseModule($input['courseModuleID']);
}
?>