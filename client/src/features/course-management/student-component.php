<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . SHARED . '/form/form-component.php';

function renderStudentTable($studentList, $intakeID)
{
?>
    <div class="table-container">
    <table class="users-table">
        <thead>
            <tr>
                <th>TP Number</th>
                <th>Student Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($studentList as $student):
            ?>
                <tr>
                    <td><?php echo $student['studentID']; ?></td>
                    <td><?php echo $student['name']; ?></td>
                    <td>
                        <form class="actions" method="post" action="#">
                            <input type="hidden" name="name" value="<?php echo $student['name']; ?>" >
                            <input type="hidden" name="studentIntakeID" value="<?php echo $student['studentIntakeID']; ?>" >
                            <input type="hidden" name="intakeID" value="<?php echo $intakeID; ?>" >
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
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php
}

function enrolStudentForm($modalName, $intakeID) {
    ob_start();
?>
    <form class="create-form" id="user-form" method="post" action="<?php echo SERVICES ?>/manage-course-service.php" enctype="multipart/form-data">
        <div class="form-body">
            <?php
            renderFormInput("studentID", "TP Number", "text", "text-input", "TP Number");
            ?>
        </div>

        <div class="form-actions">
            <input type="hidden" name="intakeID" id="intakeID" value="<?php echo $intakeID ?>">
            <button type="submit" name="enrolStudent" class="confirm-btn">Confirm</button>
            <button type="button" class="cancel-btn" onclick="closeModal('<?php echo $modalName; ?>')">Cancel</button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}

function deleteStudentForm($modalName, $studentIntakeID, $intakeID, $studentName) {
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
                    <span class="message"><?php echo 'Unenrol ' . $studentName . '?'; ?></span>
                    <span class="description">Are you sure you want to unenrol this student? This action cannot be undone.</span>
                </div>
            </div>
        </div>
        <div class="modal-actions">
            <input type="hidden" name="studentIntakeID" value="<?php echo $studentIntakeID; ?>" >
            <input type="hidden" name="intakeID" value="<?php echo $intakeID; ?>" >
            <button type="button" class="cancel-btn" onclick="closeModal('<?php echo $modalName; ?>')">Cancel</button>
            <button type="submit" name="removeStudent" class="delete-btn">Delete</button>
        </div>
    </form>

<?php
    return ob_get_clean();
}
?>