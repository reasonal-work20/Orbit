<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . SHARED . '/form/form-component.php';
require_once ROOT . SERVICES . '/manage-user-service.php';

$path = MODALS . '/modal-script.js';
echo "<script src='$path'></script>";

function renderUserTable($users)
{
?>
    <table class="users-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user):
                // Use the null coalescing operator (??) to provide a default value
                $statusValue = $user['status'] ?? 'unknown';
                $statusClass = (strtolower($statusValue) === 'active') ? 'status active' : 'status';
            ?>
                <tr>
                    <td>
                        <img src="<?php echo !empty($user['picture']) ? UPLOADS . '/' . $user['picture'] : UPLOADS . '/default-profile.png'; ?>"
                            alt="" class="profile-pic" width="32px" height="32px">
                        <span><?php echo htmlspecialchars($user['name']); ?></span>
                    </td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <div class="<?php echo $statusClass; ?>">
                            <?php echo ucfirst($statusValue); ?>
                        </div>
                    </td>
                    <td>
                        <form class="actions" method="post" action="<?php echo PAGES ?>/user-management/manage-user-page.php">
                            <input type="hidden" name="userID" value="<?php echo $user['userID']; ?>" >
                            <input type="hidden" name="name" value="<?php echo $user['name']; ?>" >
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
<?php
}

function getCreateFormContent($modalName, $userID = false) {
    ob_start();
    $user = ['name' => '', 'email' => '', 'password' => '', 'phone' => '', 'role' => '', 'qualification' => ''];
    $password = true;
    $mode = "newUser";
    if ($userID) {
        $user = getUser($userID);
        $password = false;
        $mode = "editUser";
    }
?>
    <form class="create-form" id="user-form" method="post" action="<?php echo SERVICES ?>/manage-user-service.php" enctype="multipart/form-data">
        <div class="form-body">
            <?php
            renderFormInput("name", "Name", "text", "text-input", "Enter full name", true, $user['name']);
            renderFormInput("email", "Email", "email", "text-input", "Enter email address", true, $user['email']);
            renderFormInput("password", "Password", "password", "text-input", "", $password);
            renderFormInput("phone", "Contact", "tel", 'text-input', "Enter contact number", true, $user['phone']);
            renderSegmentedControl("role", "Role", ['Student', 'Lecturer'], true, $user['role']);

            echo '<div id="qualification-container" style="display: none;">';
            renderFormInput("qualification", "Qualification", "text", "text-input", "Qualification", false, $user['qualification']);
            echo '</div>';

            renderImageUploadWithPreview("picture", "Choose Image");
            if ($userID) {
                renderSegmentedControl("status", "Status", ['Active', 'Inactive'], true, $user['status']);
            }
            ?>
        </div>

        <div class="form-actions">
            <input type="hidden" name="userID" value="<?php echo $userID; ?>" >
            <button type="submit" name="<?php echo $mode; ?>" class="confirm-btn">Confirm</button>
            <button type="button" class="cancel-btn" onclick="closeModal('<?php echo $modalName; ?>')">Cancel</button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}

function renderImageUploadWithPreview($id, $title)
{
    echo "
    <div class='form-input image-upload-sect'>
        <label for='$id'>$title</label>
        <div class='image-preview-container'>
            <div id='preview-$id' class='image-preview'>
                <span>No Image Selected</span>
            </div>
            <input type='file' id='$id' name='$id' accept='image/*' class='file-input' onchange=\"previewImage(event, 'preview-$id')\">
        </div>
    </div>
    ";
}

function renderDeleteModal($modalName, $userID, $user) {
    ob_start(); ?>
    <form class="delete-user-modal">
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
                    <span class="message"><?php echo 'Delete user ' . $user . '?'; ?></span>
                    <span class="description">Are you sure you want to delete this user? This action cannot be undone.</span>
                </div>
            </div>
        </div>
        <div class="modal-actions">
            <button type="button" class="cancel-btn" onclick="closeModal('<?php echo $modalName; ?>')">Cancel</button>
            <button type="button" class="delete-btn" onclick="window.location.href='<?php echo SERVICES ?>/manage-user-service.php?userID=<?php echo $userID; ?>'">Delete</button>
        </div>
    </form>

<?php
    return ob_get_clean();
}
?>