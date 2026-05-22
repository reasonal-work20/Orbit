<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . SHARED . '/form/form-component.php';
require_once ROOT . SERVICES . '/manage-course-service.php';

function renderScheduleTable($intakeList)
{
?>
    <div class="table-container">
    <table class="users-table">
        <thead>
            <tr>
                <th>Module Group</th>
                <th>Lecturer</th>
                <th>Location</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($intakeList as $intake):
            ?>
                <tr>
                    <td><?php echo $intake['intakeID']; ?></td>
                    <td><?php echo $intake['name']; ?></td>
                    <td><?php echo $intake['status']; ?></td>
                    <td>
                        <form class="actions" method="post" action="<?php echo PAGES ?>/course-management/manage-intake.php">
                            <input type="hidden" name="intakeID" value="<?php echo $intake['intakeID']; ?>" >
                            <button class="action-btn" id="edit-btn" name="edit" type="submit">
                                <?php
                                $editIcon = ROOT . ICONS . '/pen-edit.svg';
                                if (file_exists($editIcon)) {
                                    include $editIcon;
                                } else {
                                    echo "Edit";
                                }
                                ?>
                            </button>
                            <button class="action-btn" id="delete-btn" name="delete" type="submit">
                                <?php
                                $deleteIcon = ROOT . ICONS . '/trashcan-icon.svg';
                                if (file_exists($deleteIcon)) {
                                    include $deleteIcon;
                                } else {
                                    echo "Delete";
                                }

                                ?>
                            </button>
                            <button type="button" class="action-btn" onclick="window.location.href='<?php echo PAGES; ?>/course-management/module-page.php?intake=<?php echo $intake['intakeID']; ?>'">
                                Modules
                            </button>
                            <button type="button" class="action-btn" onclick="window.location.href='<?php echo PAGES; ?>/course-management/student-page.php?intake=<?php echo $intake['intakeID']; ?>'">
                                Students
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php
}

function addIntakeForm($modalName) {
    ob_start();
?>
    <form class="create-form" id="user-form" method="post" action="<?php echo SERVICES ?>/manage-course-service.php" enctype="multipart/form-data">
        <div class="form-body">
            <?php
            $courseList = getCourseList();
            renderFormSelect("courseID", "Course Type", $courseList, "select-input");
            renderFormInput("name", "Intake Name", "text", "text-input", "Intake Name");
            renderFormInput("short", "Short Name", "text", "text-input", "Short Name");
            renderFormInput("startDate", "Start Date", "date", "text-input", "Start Date");
            renderSegmentedControl("status", "Status", ['Open', 'In Progress', 'Completed']);
            ?>
        </div>

        <div class="form-actions">
            <button type="submit" name="addIntake" class="confirm-btn">Confirm</button>
            <button type="button" class="cancel-btn" onclick="closeModal('<?php echo $modalName; ?>')">Cancel</button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}

function editIntakeForm($modalName, $intake) {
    ob_start();
?>
    <form class="create-form" id="user-form" method="post" action="<?php echo SERVICES ?>/manage-course-service.php" enctype="multipart/form-data">
        <div class="form-body">
            <label><?php echo $intake['intakeID'] . " | " . $intake['name']; ?></label>
            <?php
            renderSegmentedControl("status-edit", "Status", ['Open', 'In Progress', 'Completed'], true, $intake['status']);
            ?>
        </div>

        <div class="form-actions">
            <input type="hidden" name="intakeID" value="<?php echo $intake['intakeID']; ?>" />
            <button type="submit" name="editIntake" class="confirm-btn">Confirm</button>
            <button type="button" class="cancel-btn" onclick="closeModal('<?php echo $modalName; ?>')">Cancel</button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}

function deleteIntakeForm($modalName, $intake) {
    ob_start(); ?>
    <form class="delete-user-modal" action="<?php echo SERVICES ?>/manage-course-service.php" method="post">
        <div class="modal-header">
            <div class="modal-content">
                <div class="featured-icon">
                    <?php
                    $warningIcon = ROOT . ICONS . '/trashcan-icon.svg';
                    if (file_exists($warningIcon)) {
                        include $warningIcon;
                    }
                    ?>
                </div>
                <div class="text-and-desc">
                    <span class="message"><?php echo 'Delete ' . $intake['intakeID'] . " | " . $intake['name'] . '?'; ?></span>
                    <span class="description">Are you sure you want to delete this intake? This action cannot be undone.</span>
                </div>
            </div>
        </div>
        <div class="modal-actions">
            <input type="hidden" name="intakeID" value="<?php echo $intake['intakeID']; ?>" >
            <button type="button" class="cancel-btn" onclick="closeModal('<?php echo $modalName; ?>')">Cancel</button>
            <button type="submit" name="deleteIntake" class="delete-btn">Delete</button>
        </div>
    </form>

<?php
    return ob_get_clean();
}
?>