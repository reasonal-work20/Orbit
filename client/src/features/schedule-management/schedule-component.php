<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . SHARED . '/form/form-component.php';
require_once ROOT . SERVICES . '/manage-schedule-service.php';

function renderScheduleTable($scheduleList, $intakeID, $week)
{
?>
    <div class="table-container">
    <table class="users-table">
        <thead>
            <tr>
                <th>Module Group</th>
                <th>Location</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($scheduleList as $schedule):
            ?>
                <tr>
                    <td><?php echo $schedule['moduleGroupID']; ?></td>
                    <td><?php echo $schedule['location']; ?></td>
                    <td><?php echo $schedule['date']; ?></td>
                    <td><?php echo $schedule['startTime']; ?></td>
                    <td><?php echo $schedule['endTime']; ?></td>
                    <td>
                        <form class="actions" method="post" action="<?php echo SERVICES ?>/manage-schedule-service.php">
                            <input type="hidden" name="intakeID" value="<?php echo $intakeID; ?>" />
                            <input type="hidden" name="week" value="<?php echo $week; ?>" />
                            <input type="hidden" name="scheduleID" value="<?php echo $schedule['scheduleID']; ?>" />
                            <button class="action-btn" id="delete-btn" name="deleteSchedule" type="submit">
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

function addScheduleForm($modalName, $moduleGroupList, $intakeID, $week) {
    ob_start();
?>
    <form class="create-form" id="user-form" method="post" action="<?php echo SERVICES ?>/manage-schedule-service.php" enctype="multipart/form-data">
        <div class="form-body">
            <?php
            renderFormSelect("moduleGroupID", "Module Group", $moduleGroupList, "select-input");
            renderFormSelect("classroomID", "Classroom", getClassrooms(), "select-input");
            renderFormInput("date", "Date", "date", "text-input", "Date");
            renderFormInput("startTime", "Start Time", "time", "text-input", "Start Time");
            renderFormInput("endTime", "End Time", "time", "text-input", "End Time");
            ?>
        </div>

        <div class="form-actions">
            <input type="hidden" name="intakeID" value="<?php echo $intakeID; ?>"/>
            <input type="hidden" name="week" value="<?php echo $week; ?>" />
            <button type="submit" name="addSchedule" class="confirm-btn">Confirm</button>
            <button type="button" class="cancel-btn" onclick="closeModal('<?php echo $modalName; ?>')">Cancel</button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}
?>