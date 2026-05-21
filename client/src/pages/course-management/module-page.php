<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
include_once ROOT . COMPONENTS . '/header.php';
include_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . SHARED . '/form/form-component.php';
require_once ROOT . NAVIGATION . '/admin-nav-bar.php';
require_once ROOT . SERVICES . '/manage-user-service.php';
require_once ROOT . SERVICES . '/manage-course-service.php';
require_once ROOT . FEATURES . '/course-management/course-module-component.php';
require_once ROOT . MODALS . '/modal.php';

if (!isset($_SESSION['userID'])) {
    header("Location: " . INDEX);
    exit();
}
$user = getUser($_SESSION['userID']); // Get user data of current logged in user
$name = $user['name'];
$role = $user['role'];
// Highlight current page on navigation bar
$_SESSION['currentPage'] = 'manageintakes';
$cssFiles = ['admin-nav-bar.css', "admin-top-bar.css", 'manage-users.css', 'form.css'];
createHead("Orbit | Intake Management", $cssFiles);

renderNavBar();
renderContentTopBar($name, $role);

if (isset($_GET['intake'])) {
    $intake = getIntake($_GET['intake']);
    if ($intake['status'] !== 'In Progress') {
        $path = PAGES . '/course-management/manage-intake.php';
        echo "<script>window.location.href='$path';</script>";
    }
} else {
    header('Location: ' . INDEX);
    exit();
}

$addCourseModuleForm = addCourseModuleForm("addCourseModuleForm", $intake['intakeID']);
$addCourseModuleModal = new Modal("addCourseModuleForm", "large");
echo $addCourseModuleModal->render("Add Module", $addCourseModuleForm);
?>

<div class="page-content">
    <div class="manage-users-container">
        <div class="title-btn-wrapper">
            <span class="manage-users-header"><?php echo $intake['intakeID']; ?></span>
            <div class="add-user-btn" onclick="openModal('addCourseModuleForm')">
                <span class="btn-text">
                    Add Module
                </span>
                <?php
                $plusIcon = ROOT . ICONS . '/plus-icon.svg';
                if (file_exists($plusIcon)) {
                    include_once $plusIcon;;
                }
                ?>
            </div>
        </div>
        <hr class="divider">

        <?php
        $courseModuleList = getCourseModuleList($intake['intakeID']);
        renderTable($courseModuleList, $intake['intakeID']);
        ?>
    </div>
</div>

<script>
</script>

<?php
createFooter(false);
if (isset($_POST['edit'])) {
    $courseModule = getCourseModule($_POST['courseModuleID']);
    $editCourseModuleForm = editCourseModuleForm("editCourseModuleForm", $intake['intakeID'], $courseModule);
    $editCourseModuleModal = new Modal("editCourseModuleForm", "medium");
    echo $editCourseModuleModal->render("Edit Course module", $editCourseModuleForm);
    echo "<script>openModal('editCourseModuleForm');</script>";
}

if (isset($_POST['delete'])) {
    $courseModule = getCourseModule($_POST['courseModuleID']);
    $deleteCourseModuleForm = deleteCourseModuleForm("deleteCourseModuleForm", $intake['intakeID'], $courseModule);
    $deleteCourseModuleModal = new Modal("deleteCourseModuleForm", "medium");
    echo $deleteCourseModuleModal->render("Delete Course module", $deleteCourseModuleForm);
    echo "<script>openModal('deleteCourseModuleForm');</script>";
}
?>