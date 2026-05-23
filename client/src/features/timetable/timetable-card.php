<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

function renderTimetableCardForDashboard($classes, $upcomingClasses, $currentTime)
{
    ob_start(); ?>
    <div class="timetable-card">
        <div class="header">
            <h3 class="title">My Schedule</h3>
        </div>
        <div class="today-upcoming">
            <div class="today">
                <span>TODAY</span>
            </div>
            <div class="upcoming">
                <span>UPCOMING</span>
            </div>
        </div>
        <div class="class-list">
            <!-- Logic here can be a for every class today, render the class item respectively. -->
            <?php
            foreach ($classes as $class) {
                renderClassItem($class, $currentTime);
            }

            ?>
        </div>
        <div class="upcoming-class-list">
            <?php
            foreach ($upcomingClasses as $upcomingClass) {
                renderClassItem($upcomingClass, $currentTime);
            }
            ?>
        </div>
    </div>

<?php
    echo ob_get_clean();
    return;
}

function renderClassItem($classInfo, $currentTime) // Uses the currentTime to determine ON RENDER if the class has been ongoing or not. If ongoing, color will be changed with css.
{
    $startTime = $classInfo['startTime'];
    $endTime = $classInfo['endTime'];
    $classLocation = $classInfo['location'];
    $lecturer = $classInfo['lecturer'];
    $module = $classInfo['module'];
    $moduleGroupID = $classInfo['moduleGroupID'];

    $classTimeStart = strtotime(trim($startTime));
    $classTimeEnd = strtotime(trim($endTime));
    $statusClass = '';
    if ($currentTime >= $classTimeStart) {
        $statusClass = 'time-passed';
    }

    ob_start(); ?>
    <div class="class-item <?php echo $statusClass ?>">
        <div class="course-and-title-wrapper">
            <h4 class="class-time">
                <?php echo date("g:i A", strtotime($startTime)) . ' (GMT+8) - ' . date("g:i A", strtotime($endTime)) . ' (GMT+8)'; ?>
            </h4>
            <span class="course-title"><?php echo $module; ?></span>
        </div>
        <div class="further-class-info">
            <div class="location-wrapper">
                <div class="bx">&#xeb58</div>
                <span class="class-location"> <?php echo $classLocation . ' | APU CAMPUS'; ?></span>
            </div>
            <div class="lecturer-profile">
                <div class="bx">&#xec65</div>
                <span class="class-lecturer"> <?php echo $lecturer; ?></span>
            </div>
        </div>
    </div>

<?php
    echo ob_get_clean();
    return;
}

?>