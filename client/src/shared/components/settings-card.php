<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . SHARED . '/form/form-component.php';

function renderUserSettingsCard()
{
    ob_start(); ?>
    <div class="settings-card" style="width: 100%">
        <a class="title-back-button" href="#" onclick="history.back(); return false;">
            <div class="icon">
                <?php
                $arrowIcon = ROOT . ICONS . '/arrow-left.svg';
                if (file_exists($arrowIcon)) {
                    include $arrowIcon;
                }
                ?>
            </div>
            <h2 class="title">Settings</h2>
        </a>
        <hr class="divider">
        <div class="settings-content">
            <?php
            // ------------> ( SETTINGS NAVIGATION IS CONTROLLED WITH JAVASCRIPT!! ) <------------- \\
            renderSettingsNavigation();

            // -------------> ( PROFILE SETTINGS SECTION  \ THE DEFAULT ) <------------- \\
            renderSettingsProfileForm();
            // ------------> ( MORE SETTINGS PAGES CAN BE ADDED BELOW IF NEEDED - BUT RIGHT NOW, NOT NEEDED ) <------------- \\
            ?>


        </div>
    </div>

<?php
    echo ob_get_clean();
    return;
}

function renderSettingsProfileForm()
{
    ob_start(); ?>

    <form class="settings-form" method="post" id="update-profile-form" action="<?php echo SERVICES; ?>/manage-user-service.php">
        <h4 class="change-password"> Change Password </h4>
        <?php
        renderFormInput("current-password", "Current Password", "password", "text-input", "Enter current password");
        renderFormInput("password", "New Password", "password", "text-input", "Enter new password");
        renderFormInput("password", "Repeat New Password", "password", "text-input", "Confirm your new password");
        ?>
        <button type="submit" name="updatePassword" class="submit-button" id="update-settings-btn" disabled>Update Profile</button>
    </form>
<?php
}

function renderSettingsNavigation()
{
    ob_start();
?>
    <div class="settings-navigation">
        <?php
        renderSettingNavItem("Profile Settings", "profile-settings");
        ?>
    </div>
<?php
    echo ob_get_clean();
    return;
}

function renderSettingNavItem($title, $id)
{
    ob_start(); ?>
    <div class="nav-item" id="<?php echo $id ?>">
        <span class="title"><?php echo $title ?></span>
    </div>
<?php
    echo ob_get_clean();
    return;
}
?>