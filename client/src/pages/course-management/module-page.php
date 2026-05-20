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
} else {
    header('Location: ' . INDEX);
    exit();
}
?>

<div class="page-content">
    <div class="manage-users-container">
        <div class="title-btn-wrapper">
            <span class="manage-users-header"><?php echo $intake['intakeID']; ?></span>
            <form action="#" method="get" style="display:flex; gap:10px;">
                <div class='form-input'>
                    <input type='text' id='search' name="search" class='text-input' placeholder='Search ...'>
                </div>
                <button type="submit" class="confirm-btn">Search</button>
            </form>
            <div class="add-user-btn" onclick="openModal('')">
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
        ?>
    </div>
</div>

<script>
</script>

<?php
createFooter(false);
?>