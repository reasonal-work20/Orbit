<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

function renderUserProfileCard($user)
{
    ob_start() ?>
    <div class="profile-card">
        <div class="profile-pic" onclick="openModal('userProfileView')">
            <img src="<?php if (file_exists(ROOT . UPLOADS . '/' . $user['picture'])) {
                            echo UPLOADS . '/' . $user['picture'];
                        } else {
                            echo UPLOADS . '/default-profile.png';
                        } ?>" alt="" width="60px" height="60px">
        </div>
        <div class="info-actions-wrapper">
            <div class="user-info">
                <h3 class="username">
                    <?php echo $user['name'] ?>
                </h3>
                <h4 class="student-id">
                    <?php 
                    if (isset($user['studentID'])) {
                        echo $user['studentID'];
                    } elseif (isset($user['lecturerID'])) {
                        echo $user['lecturerID'];
                    }
                    ?>
                </h4>
            </div>
            <a href="<?php echo SERVICES . '/logout-service'; ?>" class="logout-button">
                <?php
                $logoutIcon = ROOT . ICONS . '/logout-logo-2.svg';
                if(file_exists($logoutIcon)) {
                    include $logoutIcon;
                } else {
                    echo "Log Out";
                }
                ?>
            </a>
        </div>

    </div>

<?php
    echo ob_get_clean();
    return;
}
?>