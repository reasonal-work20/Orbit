<?php
/**
* Student Intake class model
* 
* Function
* create    -> :param > studentID, intakeID
*           -> Returns an associated array [error, id]
*
* delete    -> :param > studentIntakeID
*           -> Returns an associated array [error]
*/

class StudentIntake {
    private $connection;

    public function __construct($database) {
        $this->connection = $database;
    }

    public function create($studentID, $intakeID):array {
        $result = ["error" => True, "id" => ""];
        $sql = "INSERT INTO student_intake (student_id, intake_id) VALUES ('$studentID', '$intakeID');";
        if (mysqli_query($this->connection, $sql)) {
            $result["id"] = mysqli_insert_id($this->connection);
            $result["error"] = False;
        }
        return $result;
    }

    public function delete($studentIntakeID):array {
        $result = ["error" => True];
        $sql = "DELETE FROM student_intake WHERE student_intake_id = $studentIntakeID;";
        if (mysqli_query($this->connection, $sql)) {
            $result["error"] = False;
        }
        return $result
    }
}
?>