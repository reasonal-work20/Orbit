<?php
function renderTable($courseModuleList, $intakeID)
{
?>
    <div class="table-container">
    <table class="users-table">
        <thead>
            <tr>
                <th>Module Code</th>
                <th>Details</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courseModuleList as $courseModule):
            ?>
                <tr>
                    <td><?php echo $courseModule['moduleID']; ?></td>
                    <td><?php echo $courseModule['name']; ?></td>
                    <td><?php echo $courseModule['startDate']; ?></td>
                    <td><?php echo $courseModule['endDate']; ?></td>
                    <td>
                        <form class="actions" method="post" action="<?php echo PAGES ?>/course-management/module-page.php?intake=<?php echo $intakeID; ?>">
                            <input type="hidden" name="courseModuleID" value="<?php echo $courseModule['courseModuleID']; ?>" >
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
                        </form>
                    </td>
                </tr>
                <?php foreach ($courseModule['group'] as $row) { ?>
                    <tr>
                        <td></td>
                        <td><?php echo $row['moduleGroupID']; ?></td>
                        <td></td>
                        <td></td>
                        <td>
                        </td>
                    </tr>
            <?php } endforeach; ?>
        </tbody>
    </table>
    </div>
<?php
}

function addCourseModuleForm($modalName, $intakeID) {
    ob_start();
?>
    <form class="create-form" id="user-form" method="post" action="<?php echo SERVICES ?>/manage-course-service.php" enctype="multipart/form-data">
        <div class="form-body">
            <?php
            $lecturerList = getLecturer();
            $tempList = getModuleList("");
            $moduleList = [];
            foreach ($tempList as $module) {
                $moduleList[$module['moduleID']] = $module['moduleID'] . " | " . $module['name'];
            }
            renderFormSelect("moduleID", "Module", $moduleList, "select-input");
            renderFormSelect("lecturerID", "Assign Lecturer", $lecturerList, "select-input");
            renderFormInput("startDate", "Start Date", "date", "text-input", "Start Date");
            renderFormInput("endDate", "End Date", "date", "text-input", "End Date");
            renderFormSelect("lecture", "Lecture Session", ["Yes" => "Yes", "No" => "No"], "select-input");
            renderSegmentedControl("type", "Other", ['Tutorial', 'Lab', 'None']);
            ?>
        </div>

        <div class="form-actions">
            <input type="hidden" name="intakeID" value="<?php echo $intakeID; ?>" >
            <button type="submit" name="addCourseModule" class="confirm-btn">Confirm</button>
            <button type="button" class="cancel-btn" onclick="closeModal('<?php echo $modalName; ?>')">Cancel</button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}

function editCourseModuleForm($modalName, $intake, $courseModule) {
    ob_start();
?>
    <form class="create-form" id="user-form" method="post" action="<?php echo SERVICES ?>/manage-course-service.php" enctype="multipart/form-data">
        <div class="form-body">
            <?php
            $lecturerList = getLecturer();
            renderFormSelect("lecturerID", "Assign Lecturer", $lecturerList, "select-input", true, $courseModule['lecturerID']);
            renderFormInput("startDate", "Start Date", "date", "text-input", "Start Date", true, $courseModule['startDate']);
            renderFormInput("endDate", "End Date", "date", "text-input", "End Date", true, $courseModule['endDate']);
            ?>
        </div>

        <div class="form-actions">
            <input type="hidden" name="intakeID" value="<?php echo $intake ?>" />
            <input type="hidden" name="courseModuleID" value="<?php echo $courseModule['courseModuleID']; ?>" />
            <button type="submit" name="editCourseModule" class="confirm-btn">Confirm</button>
            <button type="button" class="cancel-btn" onclick="closeModal('<?php echo $modalName; ?>')">Cancel</button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}

function deleteCourseModuleForm($modalName, $intake, $courseModule) {
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
                    <span class="message"><?php echo 'Delete ' . $courseModule['moduleID'] . '?'; ?></span>
                    <span class="description">Are you sure you want to delete this course module? This action cannot be undone.</span>
                </div>
            </div>
        </div>
        <div class="modal-actions">
            <input type="hidden" name="intakeID" value="<?php echo $intake; ?>" >
            <input type="hidden" name="courseModuleID" value="<?php echo $courseModule['courseModuleID'] ?>" >
            <button type="button" class="cancel-btn" onclick="closeModal('<?php echo $modalName; ?>')">Cancel</button>
            <button type="submit" name="deleteCourseModule" class="delete-btn">Delete</button>
        </div>
    </form>

<?php
    return ob_get_clean();
}
?>