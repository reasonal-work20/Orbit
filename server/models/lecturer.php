<?php
/** 
* Class model for lecturers.
*/

class Lecturer {
    private $connection;

    public function __construct($database) {
        $this->connection = $database;
    }

    public function createLecturer($userID, $qualification):array {
        $result = [
            "error" => True,
            "id" => ""
        ];

        $sql = "INSERT INTO lecturer (user_id, qualification, status)
                VALUES ($userID, '$qualification', 'Active');";
        if (mysqli_query($this->connection, $sql)) {
            $result["id"] = mysqli_insert_id($this->connection);
            $result["error"] = False;
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
        $result = ["error" => True];

        $sql = "UPDATE lecturer
                SET qualification = '$qualification', status = '$status'
                WHERE lecturer_id = '$lecturerID';";
        if (mysqli_query($this->connection, $sql)) {
            $result["error"] = False;
        }

        return $result;
    }

    // public function deleteLecturer($lecturerID) {
    //     $result = ["error" => True];

    //     $sql = "DELETE FROM lecturer WHERE lecturer_id = '$lecturerID';";
    //     if (mysqli_query($connection, $sql)) {
    //         $result["error"] = False;
    //     }

    //     return $result;
    // }
}
?>