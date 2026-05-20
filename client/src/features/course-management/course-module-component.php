<?php
function renderTable($courseModuleList, $intakeID)
{
?>
    <div class="table-container">
    <table class="users-table">
        <thead>
            <tr>
                <th>Module Code</th>
                <th>Module Name</th>
                <th>Lecturer</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courseModuleList as $courseModule):
            ?>
                <tr>
                    <td></td>
                    <td><?php echo $courseModule['name']; ?></td>
                    <td><?php echo $courseModule['lecturer']; ?></td>
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
                <?php foreach ($courseModule['moduleGroup'] as $row) { ?>
                    <tr>
                        <td><?php echo $row['moduleGroupID']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <form class="actions" method="post" action="<?php echo PAGES ?>/course-management/module-page.php?intake=<?php echo $intakeID; ?>">
                                <input type="hidden" name="moduleGroupID" value="<?php echo $row['moduleGroupID']; ?>" >
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
            <?php } endforeach; ?>
        </tbody>
    </table>
    </div>
<?php
}
?>