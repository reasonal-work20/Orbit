<?php
/** 
* Class model for students.
*
* Student class constructor takes in the parameter database to establish connection to the database.
*
* Functions
* createStudent -> :param -> userID of the student's user account.
*               -> Returns an associated array containing the error status and id of the created student. 
*               -> Key -> [error, id]
* 
* getStudent    -> :param -> id referring to either studentID or userID.
*               -> Returns an associated array containing the error status and details of the selected student. 
*               -> Key -> [error, studentID, userID, status]
*
* updateStudent -> :param -> studentID, status of the student (either Active or Inactive).
*               -> Returns an associated array containing the error status. 
*               -> Key -> [error]
*/

class Student {
    private $connection;

    public function __construct($database) {
        $this->connection = $database;
    }

    public function createStudent($userID):array {
        $result = [
            "error" => True,
            "id" => ""
        ];

        $sql = "INSERT INTO student (user_id, status) 
                VALUES ($userID, 'Active')";
        if (mysqli_query($this->connection, $sql)) {
            $result["error"] = False;
            $result["id"] = mysqli_insert_id($this->connection);
        }

        return $result;
    }

    public function getStudent($id):array {
        $result = [
            "error" => True,
            "studentID" => "",
            "userID" => 0,
            "status" => ""
        ];

        $sql = "SELECT * FROM student WHERE student_id = '$id' OR user_id = $id;";
        $statement = mysqli_query($this->connection, $sql);
        $student = mysqli_fetch_array($statement);
        if ($student) {
            $result["error"] = False;
            $result["studentID"] = $student["student_id"];
            $result["userID"] = $student["user_id"];
            $result["status"] = $student["status"];
        }

        return $result;
    }

    public function updateStudent($studentID, $status):array {
        $result = ["error" => True];
        
        $sql = "UPDATE student
                SET status = '$status'
                WHERE student_id = '$studentID';";
        if (mysqli_query($this->connection, $sql)) {
            $result["error"] = False;
        }

        return $result;
    }
}
?>