<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . SHARED . '/form/form-component.php';

function renderCourseTable($moduleList, $majorID)
{
?>
    <div class="table-container">
    <table class="users-table">
        <thead>
            <tr>
                <th>Module Code</th>
                <th>Module Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($moduleList as $module):
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($module['moduleID']); ?></td>
                    <td><?php echo htmlspecialchars($module['name']); ?></td>
                    <td>
                        <form class="actions" method="post" action="<?php echo PAGES ?>/course-management/dashboard.php">
                            <input type="hidden" name="moduleID" value="<?php echo $module['moduleID']; ?>" >
                            <input type="hidden" name="majorID" value="<?php echo $majorID; ?>" >
                            <input type="hidden" name="count" value="<?php echo $module['row']; ?>" >
                            <input type="hidden" name="name" value="<?php echo $module['name']; ?>" >
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
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php
}

function addModuleForm($modalName, $majorID) {
    ob_start();
?>
    <form class="create-form" id="user-form" method="post" action="<?php echo SERVICES ?>/manage-course-service.php" enctype="multipart/form-data">
        <div class="form-body">
            <?php
            renderFormInput("name", "Module Name", "text", "text-input", "Module Name");
            renderFormInput("short", "Module Short Name", "text", "text-input", "Module Short Name");
            ?>
        </div>

        <div class="form-actions">
            <input type="hidden" name="majorID" id="majorID" value="<?php echo $majorID ?>">
            <button type="submit" name="addModule" class="confirm-btn">Confirm</button>
            <button type="button" class="cancel-btn" onclick="closeModal('<?php echo $modalName; ?>')">Cancel</button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}

function editModuleForm($modalName, $majorID, $moduleID, $moduleName) {
    ob_start();
?>
    <form class="create-form" id="user-form" method="post" action="<?php echo SERVICES ?>/manage-course-service.php" enctype="multipart/form-data">
        <div class="form-body">
            <?php
            renderFormInput("name", "Module Name", "text", "text-input", "Module Name", true, $moduleName);
            ?>
        </div>

        <div class="form-actions">
            <input type="hidden" name="moduleID" id="moduleID" value="<?php echo $moduleID ?>" >
            <input type="hidden" name="majorID" id="majorID" value="<?php echo $majorID ?>">
            <button type="submit" name="editModule" class="confirm-btn">Confirm</button>
            <button type="button" class="cancel-btn" onclick="closeModal('<?php echo $modalName; ?>')">Cancel</button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}

function deleteModuleForm($modalName, $majorID, $moduleID, $moduleName, $count) {
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
                    <span class="message"><?php echo 'Delete ' . $moduleName . '? There is ' . $count . ' courses using this module'; ?></span>
                    <span class="description">Are you sure you want to delete this module? This action cannot be undone.</span>
                </div>
            </div>
        </div>
        <div class="modal-actions">
            <input type="hidden" name="majorID" value="<?php echo $majorID; ?>" >
            <input type="hidden" name="moduleID" value="<?php echo $moduleID; ?>" >
            <button type="button" class="cancel-btn" onclick="closeModal('<?php echo $modalName; ?>')">Cancel</button>
            <button type="submit" name="deleteModule" class="delete-btn">Delete</button>
        </div>
    </form>

<?php
    return ob_get_clean();
}
?>