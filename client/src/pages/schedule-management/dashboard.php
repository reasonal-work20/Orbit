<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
include_once ROOT . COMPONENTS . '/header.php';
include_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . SHARED . '/form/form-component.php';
require_once ROOT . NAVIGATION . '/admin-nav-bar.php';
require_once ROOT . SERVICES . '/manage-user-service.php';
require_once ROOT . MODALS . '/modal.php';

if (!isset($_SESSION['userID'])) {
    header("Location: " . INDEX);
    exit();
}
$user = getUser($_SESSION['userID']); // Get user data of current logged in user
$name = $user['name'];
$role = $user['role'];
// Highlight current page on navigation bar
$_SESSION['currentPage'] = 'manageschedules';
$cssFiles = ['admin-nav-bar.css', "admin-top-bar.css", 'manage-users.css', 'form.css'];
createHead("Orbit | Schedule Management", $cssFiles);

renderNavBar();
renderContentTopBar($name, $role);

// $moduleCreateForm = addModuleForm("createModuleForm", $majorID);
// $createModuleModal = new Modal('createModuleForm', 'large');
// echo $createModuleModal->render("Create New Module", $moduleCreateForm);
?>

<div class="page-content">
    <div class="manage-users-container">
        <div class="title-btn-wrapper">
            <span class="manage-users-header">Schedule List</span>
            
            <?php
            echo "
            <div class='form-input'>
                <select id='selectIntake' name='selectIntake' class='select-input'>";

            echo "
                </select>
            </div>
            ";

            echo "
            <div class='form-input'>
                <select id='selectWeek' name='selectWeek' class='select-input'>";

            echo "
                </select>
            </div>
            ";
            ?>

            <div class="add-user-btn" onclick="openModal('')">
                <span class="btn-text">
                    Add New Week
                </span>
                <?php
                $userPlusIcon = ROOT . ICONS . '/plus-icon.svg';
                if (file_exists($userPlusIcon)) {
                    include_once $userPlusIcon;;
                }
                ?>
            </div>
        </div>
        <hr class="divider">

        <?php
        ?>
    </div>
</div>

<script>
    // document.getElementById("selectMajor").addEventListener("change", function (event) {
    //     let majorID = this.value;
    //     window.location.href='/Orbit/client/src/pages/course-management/dashboard.php?major=' + majorID;
    // });
</script>

<?php
createFooter(false);

// if (isset($_POST['delete'])) {
//     $deleteHtml = deleteModuleForm("deleteModuleView", $_POST['majorID'], $_POST['moduleID'], $_POST['name'], $_POST['count']);
//     $deleteModal = new Modal('deleteModuleView', 'medium');
//     echo $deleteModal->render('Delete Module', $deleteHtml);
//     echo "<script>openModal('deleteModuleView');</script>";
// }

// if (isset($_POST['edit'])) {
//     $editModuleForm = editModuleForm("editModuleView", $_POST['majorID'], $_POST['moduleID'], $_POST['name']);
//     $editModuleModal = new Modal('editModuleView', 'large');
//     echo $editModuleModal->render('Edit Module', $editModuleForm);
//     echo "<script>
//     openModal('editModuleView');
//     console.log('Something went wrong here.');
//     </script>";
// }
?>