<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

function renderUserMoreActionsContainer()
{
    ob_start(); ?>
    <div class="more-actions-container">
        <h2 class="title">More</h2>
        <div class="more-card-grid">
            <!-- Render Cards Here -->
            <?php
            renderUserMoreCard("Settings", "Change your preferences and account password.", "settings-icon.svg", "settings");
            renderUserMoreCard("Carpool Hub", "Visit the carpool hub to join carpools with colleagues.", 'car-icon.svg', "transport");
            renderUserMoreCard("Campus Directory", "Search for locations around campus.", 'map-icon.svg', "directory");
            renderUserMoreCard("Bus Shuttle", "View bus shuttle times", "bus-icon.svg", "bus");
            renderLogOutCard();
            ?>
        </div>
    </div>
<?php
    $result = ob_get_clean();
    echo $result;
}

function renderUserMoreCard(string $title, string $description, string $iconFile, string $redirectUrl)
{
    ob_start(); ?>
    <a class="more-card" href="<?php echo APP . $redirectUrl; ?>">
        <div class="icon-container">
            <?php
            $iconPath = ROOT . ICONS . '/' . $iconFile;
            if (file_exists($iconPath)) {
                include $iconPath;
            }
            ?>
        </div>
        <h3 class="title"><?php echo $title; ?></h3>
        <span class="description"><?php echo $description; ?></span>
    </a>
<?php
    $result = ob_get_clean();
    echo $result;
}

function renderLogOutCard()
{
    ob_start(); ?>
    <a class="more-card" href="<?php echo SERVICES . '/logout-service'; ?>">
        <div class="icon-container">
            <?php
            $iconPath = ROOT . ICONS . '/logout-logo-2.svg';
            if (file_exists($iconPath)) {
                include $iconPath;
            }
            ?>
        </div>
        <h3 class="title">Log Out</h3>
        <span class="description">Log out of the system. You can log back in anytime.</span>
    </a>
<?php
    $result = ob_get_clean();
    echo $result;
}
?>
