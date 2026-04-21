<?php
/**
* Class model for intake.
*/

public class Intake() {
    private $connection;

    public function __construct($connection) {
        $this->$connection = $connection;
    }

    public function createIntake($courseID, $name, $startDate, $status, $short, $group) {
        $result = [
            "intakeError" => True,
            "groupError" => True,
            "id" => ""
        ];

        $yearMonth = date("ym", strtotime($startDate));
        $intakeID = $courseID . $yearMonth . $short;
        $sql = "INSERT INTO intake (intake_id, course_id, name, start_date, status)
                VALUES ('$intakeID', '$courseID', '$name', '$startDate', 'Open');";
        if (!mysqli_query($connection, $sql)) {
            return $result;
        }

        $result["id"] = mysqli_insert_id($connection);
        for ($index = 1; $index <= $group; $index++) {
            $sql = "INSERT INTO intake_group (intake_group_id, intake_id, name) VALUES ('$intakeID-G$index', '$intakeID', 'G$index');";
            if (mysqli_query($connection, $sql)) {
                $result["groupError"] = False;
            }
        }

        return $result;
    }

    public function updateIntake($intakeID, $name, $status) {
        $result = ["error" => True];
        $sql = "UPDATE intake SET name = '$name', status = '$status' WHERE intake_id = '$intakeID';";
        if (mysqli_query($connection, $sql)) {
            $result["error"] = False;
        }
        return $result;
    }

    public function deleteIntake($intakeID) {
        $result = ["error" => True];
        $sql = "DELETE FROM intake WHERE intake_id = '$intakeID';";
        if (mysqli_query($connection, $sql)) {
            $result["error"] = False;
        }
        return $result;
    }
}
?>