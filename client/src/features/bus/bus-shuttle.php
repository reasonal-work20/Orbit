<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

// Initialize variables
date_default_timezone_set('Asia/Kuala_Lumpur');
$currentTime = time();

function renderUpcomingTripCard($currentTime)
{
    ob_start(); ?>

    <div class="upcoming-trip-card">
        <div class="card-head">
            <span class="title">Upcoming Trips</span>
            <!-- <a href='<?php echo PAGES . '/bus-shuttle-page.php'?>' class="show-more">View All</a> -->
        </div>
        <div class="card-body">

            <!-- Direction 1: Campus to LRT -->
            <div class="bus-shuttle-wrapper" id="campusToLrt">
                <div class="title">APU CAMPUS -> LRT BUKIT JALIL</div>
                <div class="times-container">
                    <?php
                    $lrtTimes = getUpcomingShuttleTimes('campus-to-lrt.txt', $currentTime);
                    if (!empty($lrtTimes)) {
                        foreach ($lrtTimes as $time) {
                            renderTimeWrapper($time);
                        }
                    } else {
                        echo '<p class="no-shuttle">No more shuttles today</p>';
                    }
                    ?>
                </div>
            </div>

            <!-- Direction 2: LRT to Campus -->
            <div class="bus-shuttle-wrapper" id="lrtToCampus">
                <div class="title">LRT BUKIT JALIL -> APU CAMPUS</div>
                <div class="times-container">
                    <?php
                    $campusTimes = getUpcomingShuttleTimes('lrt-to-campus.txt', $currentTime);
                    if (!empty($campusTimes)) {
                        foreach ($campusTimes as $time) {
                            renderTimeWrapper($time);
                        }
                    } else {
                        echo '<p class="no-shuttle">No more shuttles today</p>';
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>

<?php
    echo ob_get_clean();
}

function renderTimeWrapper($timeString)
{
    $formattedTime = date("g:i A", strtotime($timeString));
?>
    <div class="time-wrapper">
        <span class="time"><?php echo htmlspecialchars($formattedTime) ?></span>
    </div>
<?php
}