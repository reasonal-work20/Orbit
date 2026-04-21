<?php
/** 
* Class model for students.
*/

public class Student() {
    private $connection;

    public function __construct($database) {
        $this->$connection = $database;
    }

    public function createStudent($userID, $intakeGroupID):array {
        $result = [
            "error" => True,
            "id" => ""
        ];

        $sql = "INSERT INTO student (user_id, intake_group_id, status) 
                VALUES ($userID, '$intakeGroupID', 'Active')";
        if (mysqli_query($connection, $sql)) {
            $result["error"] = False;
            $result["id"] = mysqli_insert_id($connection);
        }

        return $result;
    }

    public function getStudent($id):array {
        $result = [
            "error" => True,
            "studentID" => "",
            "userID" => 0,
            "intakeGroupID" => "",
            "status" => ""
        ];

        $sql = "SELECT * FROM student WHERE student_id = '$id' OR user_id = $id;";
        $statement = mysqli_query($connection, $sql);
        $student = mysqli_fetch_array($statement);
        if ($student) {
            $result["error"] = False;
            $result["studentID"] = $student["student_id"];
            $result["userID"] = $student["user_id"];
            $result["intakeGroupID"] = $student["intake_group_id"];
            $result["status"] = $student["status"];
        }

        return $result;
    }

    public function updateStudent($studentID, $intakeGroupID, $status):array {
        $result = ["error" => True];
        
        $sql = "UPDATE student
                SET intake_group_id = '$intakeGroupID', status = '$status'
                WHERE student_id = '$studentID';";
        if (mysqli_query($connection, $sql)) {
            $result["error"] = False;
        }

        return $result;
    }

    // public function deleteStudent($studentID):array {
    //     $result = ["error" => True];

    //     $sql = "DELETE FROM student WHERE student_id = '$studentID';";
    //     if (mysqli_query($connection, $sql)) {
    //         $result["error"] = False;
    //     }

    //     return $result;
    // }
}
?>