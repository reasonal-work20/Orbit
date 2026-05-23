<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONFIG;
require_once ROOT . MODELS . '/schedule.php';
require_once ROOT . MODELS . '/lecturer.php';
require_once ROOT . CONTROLLERS . '/manage-user.php';

class ScheduleController {
    private $connection;
    private $scheduleEditor;
    private $lecturerEditor;
    private $manageUser;

    public function __construct() {
        global $connect;
        $this->connection = $connect;
        $this->scheduleEditor = new Schedule($connect);
        $this->lecturerEditor = new Lecturer($connect);
        $this->manageUser = new ManageUser();
    }

    public function getClassrooms() {
        $sql = "SELECT * FROM classroom c LEFT JOIN location l ON c.location_id = l.location_id;";
        $statement = mysqli_query($this->connection, $sql);
        $result = [];
        while ($row = mysqli_fetch_array($statement)) {
            $result[$row['classroom_id']] = "[" . $row['capacity'] . "] " . $row['name']; 
        }
        return $result;
    }

    public function getWeeks() {
        $sql = "SELECT DISTINCT(date) AS date FROM schedule ORDER BY date ASC;";
        $statement = mysqli_query($this->connection, $sql);
        $result = [];
        while ($date = mysqli_fetch_array($statement)) {
            if (date("N", strtotime($date['date'])) == 1) {
                $result[] = $date['date'];
            } else {
                $temp = new DateTime($date['date']);
                $temp->modify('Monday this week');
                if (!in_array($temp->format('Y-m-d'), $result)) {
                    $result[] = $temp->format('Y-m-d');
                }
            }
        }
        return $result;
    }

    public function getScheduleList($filter) {
        if ($filter['intakeID'] === $filter['week'] && $filter['intakeID'] === "All") {
            $sql = "SELECT * FROM schedule s
                    LEFT JOIN classroom c ON s.classroom_id = c.classroom_id
                    LEFT JOIN location l ON l.location_id = c.location_id
                    ORDER BY date DESC";
        } elseif ($filter['intakeID'] === "All") {
            $start = $filter['week'];
            $week = "WHERE s.date = '$start'";
            for ($count = 1; $count < 7; $count++) {
                $date = new DateTime($filter['week']);
                $date->modify("+$count day");
                $temp = $date->format("Y-m-d");
                $week = $week . " OR s.date = '$temp'";
            }
            $sql = "SELECT * FROM schedule s
                    LEFT JOIN classroom c ON s.classroom_id = c.classroom_id
                    LEFT JOIN location l ON l.location_id = c.location_id
                    $week
                    ORDER BY date DESC";
        } elseif ($filter['week'] === "All") {
            $intakeID = $filter['intakeID'];
            $sql = "SELECT * FROM schedule s
                    LEFT JOIN module_group m ON m.module_group_id = s.module_group_id
                    LEFT JOIN course_module c ON m.course_module_id = c.course_module_id
                    LEFT JOIN classroom b ON s.classroom_id = b.classroom_id
                    LEFT JOIN location l ON b.location_id = l.location_id
                    WHERE c.intake_id = '$intakeID'
                    ORDER BY date DESC;";
        } else {
            $start = $filter['week'];
            $week = "WHERE (s.date = '$start'";
            for ($count = 1; $count < 7; $count++) {
                $date = new DateTime($filter['week']);
                $date->modify("+$count day");
                $temp = $date->format("Y-m-d");
                $week = $week .  " OR s.date = '$temp'";
            }
            $intakeID = $filter['intakeID'];
            $sql = "SELECT * FROM schedule s
                    LEFT JOIN module_group m ON m.module_group_id = s.module_group_id
                    LEFT JOIN course_module c ON m.course_module_id = c.course_module_id
                    LEFT JOIN classroom b ON s.classroom_id = b.classroom_id
                    LEFT JOIN location l ON b.location_id = l.location_id
                    $week)
                    AND c.intake_id = '$intakeID'
                    ORDER BY date DESC;";
        }

        $statement = mysqli_query($this->connection, $sql);
        $result = [];
        while ($schedule = mysqli_fetch_array($statement)) {
            $result[] = [
                "scheduleID" => $schedule['schedule_id'],
                "moduleGroupID" => $schedule['module_group_id'],
                "locationID" => $schedule["location_id"],
                "location" => $schedule["name"],
                "startTime" => $schedule["start_time"],
                "endTime" => $schedule["end_time"],
                "date" => $schedule["date"]
            ];
        }
        return $result;
    }

    public function getSchedule($scheduleID) {
        $schedule = $this->scheduleEditor->get($scheduleID);
        if (empty($schedule)) {
            return [];
        }
        $classroomID = $schedule['classroomID'];
        $sql = "SELECT * FROM classroom c
                LEFT JOIN location l ON c.location_id = l.location_id
                WHERE c.classroom_id = '$classroomID';";
        $statement = mysqli_query($this->connection, $sql);
        $classroom = mysqli_fetch_array($statement);
        $moduleGroupID = $schedule['moduleGroupID'];
        $sql = "SELECT l.lecturer_id AS lecturer_id, u.name AS lecturer_name, m.name as module_name FROM module_group g
                LEFT JOIN course_module c ON g.course_module_id = c.course_module_id
                LEFT JOIN module m ON m.module_id = c.module_id
                LEFT JOIN lecturer l ON c.lecturer_id = l.lecturer_id
                LEFT JOIN user u ON u.user_id = l.user_id
                WHERE g.module_group_id = '$moduleGroupID';";
        $statement = mysqli_query($this->connection, $sql);
        $moduleGroup = mysqli_fetch_array($statement);
        return [
            "scheduleID" => $scheduleID,
            "locationID" => $classroom["location_id"],
            "location" => $classroom["name"],
            "lecturerID" => $moduleGroup['lecturer_id'],
            "lecturer" => $moduleGroup['lecturer_name'],
            "moduleGroupID" => $moduleGroupID,
            "module" => $moduleGroup['module_name'],
            "startTime" => $schedule["startTime"],
            "endTime" => $schedule["endTime"],
            "date" => $schedule["date"]
        ];
    }

    public function createSchedule(array $input) {
        $error = $this->scheduleEditor->create(
            $input['moduleGroupID'], 
            $input['classroomID'], 
            $input['startTime'], 
            $input['endTime'],
            $input['date']);

        if ($error['error']) {
            return "An error has occurred while scheduling the class.";
        }
        return "";
    }

    public function updateSchedule(array $input) {
        $error = $this->scheduleEditor->update(
            $input['scheduleID'],
            $input['classroomID'],
            $input['startTime'],
            $input['endTime'],
            $input['date']
        );
        if ($error['error']) {
            return "An error has occurred while updating the schedule.";
        }
        return "";
    }

    public function deleteSchedule($scheduleID) {
        $error = $this->scheduleEditor->delete($scheduleID);
        if ($error['error']) {
            return "An error has occurred while deleting the schedule.";
        }
        return "";
    }
}
?>