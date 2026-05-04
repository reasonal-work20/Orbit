<?php
/** 
* Class model for lecturers.
*
* Lecturer class constructor takes in the parameter database to establish connection to the database.
* 
* Functions
* createLecturer    -> :param -> userID of the lecturer's user account, qualification
*                   -> Returns an associated array containing the error status and id of the created lecturer.
*                   -> Key -> [error, id]
*
* getLecturer       -> :param -> id referring to either lecturerID or userID.
*                   -> Returns an associated array containing the error status and details of the lecturer selected.
*                   -> Key -> [error, lecturerID, userID, qualification, status]
*
* updateLecturer    -> :param -> lecturerID, qualification, status of the lecturer (Active or Inactive)
*                   -> Returns an associated array containing the error status.
*                   -> Key -> [error]
*/

class Lecturer {
    private $connection;

    public function __construct($database) {
        $this->connection = $database;
    }

    public function createLecturer($userID, $qualification):array {
        $sql = "INSERT INTO lecturer (user_id, qualification, status)
                VALUES ($userID, '$qualification', 'Active');";
        try {
            mysqli_query($this->connection, $sql);
            $result = ["error" => False, "id" => mysqli_insert_id($this->connection)];
        } catch (mysqli_sql_exception $e) {
            $result = ["error" => True];
        }
        return $result;
    }

    public function getLecturer($id):array {
        $result = [
            "error" => True,
            "lecturerID" => "",
            "userID" => 0,
            "qualification" => "",
            "status" => ""
        ];

        $sql = "SELECT * FROM lecturer WHERE lecturer_id = '$id' OR user_id = $id;";
        $statement = mysqli_query($this->connection, $sql);
        $lecturer = mysqli_fetch_array($statement);
        if ($lecturer) {
            $result["lecturerID"] = $lecturer["lecturer_id"];
            $result["userID"] = $lecturer["user_id"];
            $result["qualification"] = $lecturer["qualification"];
            $result["status"] = $lecturer["status"];
            $result["error"] = False;
        }

        return $result;
    }

    public function updateLecturer($lecturerID, $qualification, $status) {
        $sql = "UPDATE lecturer
                SET qualification = '$qualification', status = '$status'
                WHERE lecturer_id = '$lecturerID';";
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