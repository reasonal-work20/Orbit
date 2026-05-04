<?php
/**
* Class model for intake.
*
* Functions
* createIntake  -> :param > courseID, name, startDate
*               -> Returns an associated array [error, id]
*
* getIntake     -> :param > intakeID
*               -> Returns an associated array [error, intakeID, courseID, name, startDate, totalRegister, status]
*
* updateIntake  -> :param > intakeID, startDate, status
*               -> Returns an associated array [error]
*
* deleteIntake  -> :param > intakeID
*               -> Returns an associated array [error]
*/

class Intake {
    private $connection;

    public function __construct($database) {
        $this->connection = $database;
    }

    public function createIntake($courseID, $name, $short, $startDate):array {
        $result = ["error" => True, "id" => ""];
        $intakeID = $courseID . date("ym", strtotime($startDate)) . $short;
        $sql = "INSERT INTO intake (intake_id, course_id, name, start_date, total_register, status)
                VALUES ('$intakeID', '$courseID', '$name', '$startDate', 0, 'Active');";
        try {
            mysqli_query($this->connection, $sql);
            $result = ["error" => False, "id" => $intakeID];
        } catch (mysqli_sql_exception $e) {
            $result = ["error" => True];
        }
        return $result;
    }

    public function getIntake($intakeID):array {
        $result = [
            "error" => True,
            "intakeID" => "",
            "courseID" => "",
            "name" => "",
            "startDate" => "",
            "totalRegister" => 0,
            "status" => ""
        ];

        $sql = "SELECT * FROM intake WHERE intake_id = '$intakeID';";
        $statement = mysqli_query($this->connection, $sql);
        $intake = mysqli_fetch_array($statement);
        if ($intake) {
            $result["intakeID"] = $intake["intake_id"];
            $result["courseID"] = $intake["course_id"];
            $result["name"] = $intake["name"];
            $result["startDate"] = $intake["start_date"];
            $result["totalRegister"] = $intake["total_register"];
            $result["status"] = $intake["status"];
            $result["error"] = False;
        }
        return $result;
    }

    public function updateIntake($intakeID, $startDate, $status):array {
        $sql = "UPDATE intake SET start_date = '$startDate', status = '$status' WHERE intake_id = '$intakeID';";
        try {
            mysqli_query($this->connection, $sql);
            $result = ["error" => False];
        } catch (mysqli_sql_exception $e) {
            $result = ["error" => True];
        }
        return $result;
    }

    public function deleteIntake($intakeID):array {
        $sql = "DELETE FROM intake WHERE intake_id = '$intakeID';";
        try {
            mysqli_query($this->connection, $sql);
            $result = ["error" => False];
        } catch (mysqli_sql_exception $e) {
            $result = ["error" => True];
        }
        return $result;
    }
}
?>