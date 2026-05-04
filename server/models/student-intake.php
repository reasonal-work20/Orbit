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
        $sql = "INSERT INTO student_intake (student_id, intake_id) VALUES ('$studentID', '$intakeID');";
        try {
            mysqli_query($this->connection, $sql);
            $result = ["error" => False, "id" => mysqli_insert_id($this->connection)];
        } catch (mysqli_sql_exception $e) {
            $result = ["error" => True];
        }
        return $result;
    }

    public function delete($studentIntakeID):array {
        $sql = "DELETE FROM student_intake WHERE student_intake_id = $studentIntakeID;";
        try {
            mysqli_query($this->connection, $sql);
            $result = ["error" => False];
        } catch (mysqli_sql_exception $e) {
            $result = ["error" => True];
        }
        return $result
    }
}
?>