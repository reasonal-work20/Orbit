<?php
/**
* Schedule Model
* 
* Functions
* create    -> :param > moduleGroupID, classroomID, startTime, endTime, date
*           -> Returns associated array [error]
*
* get       -> :param > scheduleID
*           -> Returns associated array [moduleGroupID, classroomID, startTime, endTime, date]
*
* update    -> :param > scheduleID, classroomID, startTime, endTime, date
*           -> Returns associated array [error]
* 
* delete    -> :param > scheduleID
*           -> Returns associated array [error]
*/

class Schedule {
    private $connection;

    public function __construct($database) {
        $this->connection = $database;
    }

    public function create($moduleGroupID, $classroomID, $startTime, $endTime, $date) {
        $sql = "INSERT INTO schedule (module_group_id, classroom_id, start_time, end_time, date)
                VALUES ('$moduleGroupID', '$classroomID', '$startTime', '$endTime', '$date');";
        try {
            mysqli_query($this->connection, $sql);
            return ["error" => False, "id" => mysqli_insert_id($this->connection)];
        } catch (mysqli_sql_exception $e) {
            return ["error" => True];
        }
    }

    public function get($scheduleID) {
        $result = [];
        $sql = "SELECT * FROM schedule WHERE schedule_id = $scheduleID;";
        $statement = mysqli_query($this->connection, $sql);
        $schedule = mysqli_fetch_array($statement);
        if ($schedule) {
            $result['moduleGroupID'] = $schedule['module_group_id'];
            $result['classroomID'] = $schedule['classroom_id'];
            $result['startTime'] = $schedule['start_time'];
            $result['endTime'] = $schedule['end_time'];
            $result['date'] = $schedule['date'];
        }
        return $result;
    }

    public function update($scheduleID, $classroomID, $startTime, $endTime, $date) {
        $sql = "UPDATE schedule
                SET classroom_id = '$classroomID', start_time = '$startTime', end_time = '$endTime', date = '$date'
                WHERE schedule_id = $scheduleID;";
        try {
            mysqli_query($this->connection, $sql);
            return ["error" => False];
        } catch (mysqli_sql_exception $e) {
            return ["error" => True];
        }
    }

    public function delete($scheduleID) {
        $sql = "DELETE FROM schedule WHERE schedule_id = $scheduleID;";
        try {
            mysqli_query($this->connection, $sql);
            return ["error" => False];
        } catch (mysqli_sql_exception $e) {
            return ["error" => True];
        }
    }
}
?>