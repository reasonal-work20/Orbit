<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

include_once ROOT . COMPONENTS . '/header.php';
include_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . NAVIGATION . '/admin-nav-bar.php';
require_once ROOT . SERVICES . '/manage-user-service.php';
require_once ROOT . FEATURES . '/user-management/manage-user-components.php';
require_once ROOT . MODALS . '/modal.php';

if (!isset($_SESSION['userID'])) {
    header("Location: " . INDEX);
    exit();
}

$user = getUser($_SESSION['userID']); // Get user data of current logged in user

$name = $user['name'];
$role = $user['role'];

// Highlight current page on navigation bar
$_SESSION['currentPage'] = 'manageusers';

$cssFiles = ['admin-nav-bar.css', "admin-top-bar.css", 'manage-users.css', 'form.css'];

createHead("Orbit | Manage Users", $cssFiles);

$userCreateFormContent = getCreateFormContent("createUserView");
$createUserModal = new Modal('createUserView', 'large');
echo $createUserModal->render("Create New User Profile", $userCreateFormContent);

if (isset($_POST['delete'])) {
    $deleteHtml = renderDeleteModal("deleteUserView", $_POST['userID'], $_POST['name']);
    $deleteModal = new Modal('deleteUserView', 'medium');
    echo $deleteModal->render('Delete User', $deleteHtml);
    echo "<script>openModal('deleteUserView');</script>";
}

if (isset($_POST['edit'])) {
    $userEditFormContent = getCreateFormContent("editUserView", $_POST['userID']);
    $editUserModal = new Modal('editUserView', 'large');
    echo $editUserModal->render('Edit User Profile', $userEditFormContent);
    echo "<script>openModal('editUserView');</script>";
}

// Nav Bar and content top bar.
renderNavBar();
renderContentTopBar($name, $role);
?>
<div class="page-content">
    <div class="manage-users-container">
        <div class="title-btn-wrapper">
            <span class="manage-users-header">Users List</span>
            <div class="add-user-btn" onClick="openModal('createUserView')">
                <span class="btn-text">
                    Add New User
                </span>
                <?php
                $userPlusIcon = ROOT . ICONS . '/user-plus-icon.svg';
                if (file_exists($userPlusIcon)) {
                    include_once $userPlusIcon;;
                }
                ?>
            </div>
        </div>

        <hr class="divider">

        <?php
        $allUsers = getAllUser("");
        if (!empty($allUsers)) {
            renderUserTable($allUsers);
        } else {
            echo "<p>No users found.</p>";
        }
        ?>

    </div>
</div>
<script src="<?php echo FEATURES . '/user-management/create-user-form.js' ?>"></script>
<?php
createFooter(false);
?>