<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
include_once ROOT . COMPONENTS . '/header.php';
include_once ROOT . COMPONENTS . '/footer.php';
require_once ROOT . SHARED . '/form/form-component.php';
require_once ROOT . NAVIGATION . '/admin-nav-bar.php';
require_once ROOT . SERVICES . '/manage-user-service.php';
require_once ROOT . SERVICES . '/manage-schedule-service.php';
require_once ROOT . FEATURES . '/schedule-management/schedule-component.php';
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

$intakeID = "All";
$week = "All";
if (isset($_GET['intakeID'])) {
    $intakeID = $_GET['intakeID'];
}
if (isset($_GET['week'])) {
    $week = $_GET['week'];
}

$moduleGroupList = getModuleGroup($intakeID);
$scheduleCreateForm = addScheduleForm("createScheduleForm", $moduleGroupList, $intakeID, $week);
$createScheduleModal = new Modal('createScheduleForm', 'large');
echo $createScheduleModal->render("Create New Schedule", $scheduleCreateForm);
?>

<div class="page-content">
    <div class="manage-users-container">
        <div class="title-btn-wrapper">
            <span class="manage-users-header">Schedule List</span>
            
            <?php
            echo "
            <div class='form-input'>
                <select id='selectIntake' name='selectIntake' class='select-input'>
                <option value='All'>All</option>";
            $intakeList = getIntake();
            foreach ($intakeList as $intake) {
                if ($intakeID === $intake['intakeID']) {
                    $select = "selected";
                } else {
                    $select = "";
                }
                $id = $intake['intakeID'];
                echo "<option value='$id' $select>$id</option>";
            }

            echo "
                </select>
            </div>
            ";

            echo "
            <div class='form-input'>
                <select id='selectWeek' name='selectWeek' class='select-input'>
                <option value='All'>All</option>";
            $weekList = getWeeks();
            foreach ($weekList as $monday) {
                if ($monday === $week) {
                    $select = "selected";
                } else {
                    $select = "";
                }
                $format = date("M j, Y", strtotime($monday));
                echo "<option value='$monday' $select>$format</option>";
            }
            echo "
                </select>
            </div>
            ";
            ?>

            <div class="add-user-btn" onclick="openModal('createScheduleForm')">
                <span class="btn-text">
                    Add Schedule
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
        $scheduleList = getScheduleList(["intakeID" => $intakeID, "week" => $week]);
        renderScheduleTable($scheduleList, $intakeID, $week);
        ?>
    </div>
</div>

<script>
    document.getElementById("selectIntake").addEventListener("change", function (event) {
        console.log("here")
        let intakeID = document.getElementById("selectIntake").value;
        let week = document.getElementById("selectWeek").value;
        window.location.href='/Orbit/client/src/pages/schedule-management/dashboard.php?intakeID=' + intakeID + '&week=' + week;
    });

    document.getElementById("selectWeek").addEventListener("change", function (event) {
        let intakeID = document.getElementById("selectIntake").value;
        let week = document.getElementById("selectWeek").value;
        window.location.href='/Orbit/client/src/pages/schedule-management/dashboard.php?intakeID=' + intakeID + '&week=' + week;
    });
</script>

<?php
createFooter(false);
?>