<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . ROUTES . '/course-management-route.php';

if (isset($_POST['addModule'])) {
    $error = createModule($_POST);
    if ($error) {
        $_SESSION['error'] = $error;
    }
    $path = PAGES . "/course-management/dashboard.php?major=" . $_POST['majorID'];
    echo "<script>window.location.href='$path';</script>";
}

if (isset($_POST['editModule'])) {
    $error = updateModule($_POST);
    if ($error) {
        $_SESSION['error'] = $error;
    }
    $path = PAGES . '/course-management/dashboard.php?major=' . $_POST['majorID'];
    echo "<script>window.location.href='$path';</script>";
}

if (isset($_POST['deleteModule'])) {
    $error= deleteModule($_POST['moduleID']);
    if ($error) {
        $_SESSION['error'] = $error;
    }
    $path = PAGES . '/course-management/dashboard.php?major=' . $_POST['majorID'];
    echo "<script>window.location.href='$path';</script>";
}

if (isset($_POST['addIntake'])) {
    $_POST['name'] = htmlspecialchars($_POST['name']);
    $_POST['short'] = htmlspecialchars($_POST['short']);
    $error = createIntake($_POST);
    if ($error) {
        $_SESSION['error'] = $error;
    }
    $path = PAGES . '/course-management/manage-intake.php';
    echo "<script>window.location.href='$path';</script>";
}

if (isset($_POST['editIntake'])) {
    $_POST['status'] = $_POST['status-edit'];
    $error = updateIntake($_POST);
    if ($error) {
        $_SESSION['error'] = $error;
    }
    $path = PAGES . '/course-management/manage-intake.php';
    echo "<script>window.location.href='$path';</script>";
}

if (isset($_POST['deleteIntake'])) {
    $error = deleteIntake($_POST['intakeID']);
    if ($error) {
        $_SESSION['error'] = $error;
    }
    $path = PAGES . '/course-management/manage-intake.php';
    echo "<script>window.location.href='$path';</script>";
}

if (isset($_POST['enrolStudent'])) {
    $error = enrolStudent($_POST);
    if ($error) {
        $_SESSION['error'] = $error;
    }
    $path = PAGES . '/course-management/student-page.php?intake=' . $_POST['intakeID'];
    echo "<script>window.location.href='$path';</script>";
}

if (isset($_POST['removeStudent'])) {
    $error = removeStudent($_POST['studentIntakeID']);
    if ($error) {
        $_SESSION['error'] = $error;
    }
    $path = PAGES . '/course-management/student-page.php?intake=' . $_POST['intakeID'];
    echo "<script>window.location.href='$path';</script>";
}

if (isset($_POST['addCourseModule'])) {
    $error = addCourseModule($_POST);
    if ($error) {
        $_SESSION['error'] = $error;
    }
    $path = PAGES . '/course-management/module-page.php?intake=' . $_POST['intakeID'];
    echo "<script>window.location.href='$path';</script>";
}

if (isset($_POST['editCourseModule'])) {
    $error = editCourseModule($_POST);
    if ($error) {
        $_SESSION['error'] = $error;
    }
    $path = PAGES . '/course-management/module-page.php?intake=' . $_POST['intakeID'];
    echo "<script>window.location.href='$path';</script>";
}

if (isset($_POST['deleteCourseModule'])) {
    $error = deleteCourseModule($_POST);
    if ($error) {
        $_SESSION['error'] = $error;
    }
    $path = PAGES . '/course-management/module-page.php?intake=' . $_POST['intakeID'];
    echo "<script>window.location.href='$path';</script>";
}
?>