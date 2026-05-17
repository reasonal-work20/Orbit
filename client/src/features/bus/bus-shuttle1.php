<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

// Initialize variables
date_default_timezone_set('Asia/Kuala_Lumpur');
$currentTime = time();

function renderUpcomingTripCard($currentTime, $filter)
{
    ob_start(); ?>

    <div class="upcoming-trip-card">
        <div class="card-head">
            <span class="title">Upcoming Trips</span>
            <!-- <a href='<?php echo PAGES . '/bus-shuttle-page.php'?>' class="show-more">View All</a> -->
        </div>
        <div class="card-body">
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

function renderCard($id, $route, $timeList) 
{
?>
    <div class="bus-shuttle-wrapper" id="<?php echo $id; ?>">
        <div class="title"><?php $route ?></div>
        <div class="times-container">
            <?php
            if (!empty($timeList)) {
                foreach ($timeList as $time) {
                    renderTimeWrapper($time);
                }
            } else {
                echo '<p class="no-shuttle">No more shuttles today</p>';
            }
            ?>
        </div>
    </div>
<?php
}
?>