<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
include_once ROOT . COMPONENTS . '/header.php';
include_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . SHARED . '/form/form-component.php';
require_once ROOT . NAVIGATION . '/admin-nav-bar.php';
require_once ROOT . SERVICES . '/manage-user-service.php';
require_once ROOT . SERVICES . '/manage-course-service.php';
require_once ROOT . FEATURES . '/course-management/student-component.php';
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
    if ($intake['status'] === 'Completed') {
        $path = PAGES . '/course-management/manage-intake.php';
        echo "<script>window.location.href='$path';</script>";
    }
} else {
    header('Location: ' . INDEX);
    exit();
}

$enrolStudentForm = enrolStudentForm("enrolStudentForm", $intake['intakeID']);
$enrolStudentModal = new Modal("enrolStudentForm", "large");
echo $enrolStudentModal->render("Enrol Student", $enrolStudentForm);
?>

<div class="page-content">
    <div class="manage-users-container">
        <div class="title-btn-wrapper">
            <span class="manage-users-header"><?php echo $intake['intakeID']; ?></span>
            <form action="#" method="get" style="display:flex; gap:10px;">
                <div class='form-input'>
                    <input type='hidden' name='intake' value="<?php echo $intake['intakeID']; ?>">
                    <input type='text' id='search' name="search" class='text-input' placeholder='Search ...'>
                </div>
                <button type="submit" class="confirm-btn">Search</button>
            </form>
            <div class="add-user-btn" onclick="openModal('enrolStudentForm')">
                <span class="btn-text">
                    Enrol Student
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
        $searchParam = ["search" => "", "intakeID" => $_GET['intake']];
        if (isset($_GET['search'])) {
            $searchParam['search'] = $_GET['search'];
        }
        renderStudentTable(getStudentList($searchParam), $_GET['intake']);
        ?>
    </div>
</div>

<?php
createFooter(false);
if (isset($_POST['delete'])) {
    $intake = $_POST['intakeID'];
    $studentDeleteForm = deleteStudentForm("studentDeleteForm", $_POST['studentIntakeID'], $intake, $_POST['name']);
    $studentDeleteModal = new Modal("studentDeleteForm", "medium");
    echo $studentDeleteModal->render("Unenrol Student", $studentDeleteForm);
    echo "<script>openModal('studentDeleteForm');</script>";
}
?>