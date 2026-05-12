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
        $sql = "INSERT INTO student (user_id, status) VALUES ($userID, 'Active')";
        try {
            mysqli_query($this->connection, $sql);
            $result = ["error" => False, "id" => mysqli_insert_id($this->connection)];
        } catch (mysqli_sql_exception $e) {
            $result = ["error" => True];
        }
        return $result;
    }

    public function getStudent($id):array {
        $result = [
            "error" => True,
        ];

        $sql = "SELECT u.student_id AS student_id, u.user_id AS user_id, u.status AS status, i.intake_id AS intake_id, i.name AS name 
                FROM student u
                LEFT JOIN student_intake s ON s.student_id = u.student_id
                LEFT JOIN intake i ON i.intake_id = s.intake_id
                WHERE u.student_id = '$id' OR u.user_id = $id;";
        $statement = mysqli_query($this->connection, $sql);
        $student = mysqli_fetch_array($statement);
        if ($student) {
            $result["error"] = False;
            $result["studentID"] = $student["student_id"];
            $result["userID"] = $student["user_id"];
            $result["status"] = $student["status"];
            $result["intakeID"] = $student["intake_id"];
            $result["programme"] = $student["name"];
        }

        return $result;
    }

    public function updateStudent($studentID, $status):array {        
        $sql = "UPDATE student
                SET status = '$status'
                WHERE student_id = '$studentID';";
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