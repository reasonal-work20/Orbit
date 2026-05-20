<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
include_once ROOT . COMPONENTS . '/header.php';
include_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . SHARED . '/form/form-component.php';
require_once ROOT . NAVIGATION . '/admin-nav-bar.php';
require_once ROOT . SERVICES . '/manage-user-service.php';
require_once ROOT . SERVICES . '/manage-course-service.php';
require_once ROOT . FEATURES . '/course-management/intake-component.php';
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

?>

<div class="page-content">
    <div class="manage-users-container">
        <div class="title-btn-wrapper">
            <span class="manage-users-header">Intake List</span>
            <form action="#" method="get" style="display:flex; gap:10px;">
                <div class='form-input'>
                    <input type='text' id='search' name="search" class='text-input' placeholder='Search ...'>
                </div>
                <button type="submit" class="confirm-btn">Search</button>
            </form>
            <div class="add-user-btn" onclick="openModal('createIntakeForm')">
                <span class="btn-text">
                    Add New Intake
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
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
        } else {
            $search = '';
        }
        $intakeList = getIntakeList($search);
        renderIntakeTable($intakeList);

        $intakeCreateForm = addIntakeForm("createIntakeForm");
        $createIntakeModal = new Modal('createIntakeForm', 'large');
        echo $createIntakeModal->render("Create New Intake", $intakeCreateForm);
        ?>
    </div>
</div>

<script>
</script>

<?php
createFooter(false);
if (isset($_POST['edit'])) {
    $intake = getIntake($_POST['intakeID']);
    $intakeEditForm = editIntakeForm("editIntakeForm", $intake);
    $intakeEditModal = new Modal("editIntakeForm", "large");
    echo $intakeEditModal->render("Edit Intake", $intakeEditForm);
    echo "<script>openModal('editIntakeForm');</script>";
}

if (isset($_POST['delete'])) {
    $intake = getIntake($_POST['intakeID']);
    if ($intake['status'] !== "Completed") {
        $_SESSION['error'] = "This intake can't be deleted as it is not completed.";
    } else {
        $intakeDeleteForm = deleteIntakeForm("deleteIntakeForm", $intake);
        $intakeDeleteModal = new Modal("deleteIntakeForm", "medium");
        echo $intakeDeleteModal->render("Delete Intake", $intakeDeleteForm);
        echo "<script>openModal('deleteIntakeForm');</script>";
    }
}
?>