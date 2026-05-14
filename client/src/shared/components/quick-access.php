<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

function renderQuickAccessButton($buttonText, $icon, $redirectLink)
{
    ob_start() ?>
    <a class="quick-access-button" href='<?php echo $redirectLink ?>'>
        <span class="quick-access-button-text">
            <?php echo htmlspecialchars($buttonText) ?>
        </span>
        <div class="quick-access-icon">
            <?php $iconFile = ROOT . ICONS . "/" . $icon;
            if (file_exists($iconFile)) {
                include $iconFile;
            } else {
                echo "";
            }
            ?>
        </div>
    </a>
<?php
    $result = ob_get_clean();
    echo $result;
}

function renderQuickAccessCard($role)
{
    ob_start() ?>
    <div class="quick-access-card">
        <span class="quick-access-title">
            Quick Access
        </span>
        <div class="grid">
            <!-- This will be the render quick access button function -->
            <!-- Logic of role switching can be done here too for different quick access cards. -->
            <?php
            switch ($role) {
                case 'Student':
                    $carpoolUrl = PAGES . '/carpool-hub.php'; // Change This
                    renderQuickAccessButton("Carpool", "car-icon.svg", $carpoolUrl);

                    $directoryUrl = PAGES . '/navigation-map.php'; // Change This
                    renderQuickAccessButton("Campus Directory", "map-icon.svg", $directoryUrl);

                    $directoryUrl = PAGES . '/navigation-map.php'; // Change This
                    renderQuickAccessButton("Campus Directory", "map-icon.svg", $directoryUrl);

                    $directoryUrl = PAGES . '/navigation-map.php'; // Change This
                    renderQuickAccessButton("Campus Directory", "map-icon.svg", $directoryUrl);
                    break;
                case 'Lecturer':
                    $carpoolUrl = PAGES . '/carpool-hub.php'; // Change This
                    renderQuickAccessButton("Carpool", "car-icon.svg", $carpoolUrl);

                    $directoryUrl = PAGES . '/navigation-map.php'; // Change This
                    renderQuickAccessButton("Campus Directory", "map-icon.svg", $directoryUrl);

                    $directoryUrl = PAGES . '/navigation-map.php'; // Change This
                    renderQuickAccessButton("Campus Directory", "map-icon.svg", $directoryUrl);

                    $directoryUrl = PAGES . '/navigation-map.php'; // Change This
                    renderQuickAccessButton("Campus Directory", "map-icon.svg", $directoryUrl);
                    break;
                case 'User Admin':
                    $carpoolUrl = PAGES . '/user-admin/dashboard.php';
                    renderQuickAccessButton("Carpool", "car-icon.svg", $carpoolUrl);

                    $directoryUrl = PAGES . '/user-admin/more-page.php'; // Change This
                    renderQuickAccessButton("More Actions", "more-icon-vertical.svg", $directoryUrl);
                    break;
                // < ------------------ Add more cases ---------------------- >
            }
            ?>
        </div>
    </div>
<?php
    $result = ob_get_clean();
    echo $result;
}
