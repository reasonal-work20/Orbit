<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . SERVICES . '/manage-user-service.php';
require_once ROOT . SERVICES . '/manage-schedule-service.php';

function renderTimetable(array $classes)
{
        ob_start();
?>
    <div class="timetable-container">
        <?php
        $date = "";
        $classes = array_reverse($classes);
        $section = [];
        foreach ($classes as $class) {
            if ($class['date'] == $date) {
                $section[] = getSchedule($class);
            } else {
                if (!empty($section)) {
                    renderTimetableSection($date, $section);
                }
                $section = [];
                $date = $class['date'];
                $section[] = getSchedule($class);
            }
        }
        renderTimetableSection($date, $section);
        ?>
    </div>
<?php
    echo ob_get_clean();
}

function renderTimetableSection($date, array $classes)
{
    // Dynamically format the date: 'l' gives full day name (Monday), 'j M' gives day and short month (6 Apr)
    if ($date == "") {
        return;
    }
    $date = strtotime($date);
    $formattedDayAndDate = date('l, j M', $date);
    ob_start(); ?>
    <div class="timetable-section">
        <div class="day-and-date-wrapper">
            <h3 class="day-and-date"><?php echo $formattedDayAndDate; ?></h3>
        </div>
        <?php
        foreach ($classes as $class) {
            renderTimetableItem($class);
        }
        ?>
    </div>

<?php

}

function renderTimetableItem($classInfo)
{
    $startTime = $classInfo['startTime'];
    $endTime = $classInfo['endTime'];
    $classLocation = $classInfo['location'];
    $lecturer = $classInfo['lecturer'];
    $module = $classInfo['module'];
    $moduleGroupID = $classInfo['moduleGroupID'];

    ob_start(); ?>
    <div class="timetable-item">
        <div class="course-and-title-wrapper">
            <h4 class="class-code"><?php echo $moduleGroupID; ?></h4>
            <span class="course-title"><?php echo $module; ?></span>
            <div class="class-time-wrapper">
                <div class="bx">
                    &#xec45
                </div>
                <span class="class-time"> <?php echo date("g:i A", strtotime($startTime)) . ' (GMT+8) - ' . date("g:i A", strtotime($endTime)) . ' (GMT+8)'; ?></span>
            </div>
        </div>
        <div class="further-class-info">
            <div class="location-wrapper">
                <div class="bx">&#xeb58</div>
                <a class="class-location" href='<?php echo PAGES; ?>/campus-navigation/dashboard.php?point=<?php echo $classInfo['locationID']; ?>'>
                    <?php echo $classLocation . ' | APU CAMPUS'; ?>
                </a>
            </div>
            <div class="lecturer-profile">
                <div class="bx">&#xec65</div>
                <span class="class-lecturer"> <?php echo $lecturer; ?></span>
            </div>
        </div>
    </div>

<?php
}
