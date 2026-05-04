<?php
/**
* Class model for Course Module.
* 
* Functions
* createCourseModule    -> :param > moduleID, lecturerID, startDate, endDate
*                       -> Returns an associated array [error, id]
*
* getCourseModule       -> :param > courseModuleID
*                       -> Returns an associated array [error, courseModuleID, moduleID, lecturerID, startDate, endDate]
*
* updateCourseModule    -> :param > courseModuleID, lecturerID, startDate, endDate
*                       -> Returns an associated array [error]
*
* deleteCourseModule    -> :param > courseModuleID
*                       -> Returns an associated array [error]
*/

class CourseModule {
    private $connection;

    public function __construct($connection) {
        $this->$connection = $connection;
    }

    public function createCourseModule($moduleID, $lecturerID, $startDate, $endDate):array {
        $result = ["error" => True, "id" => 0];
        $sql = "INSERT INTO course_module (module_id, lecturer_id, start_date, end_date)
                VALUES ('$moduleID', '$lecturerID', '$startDate', '$endDate');";
        if (mysqli_query($this->connection, $sql)) {
            $result["error"] = False;
            $result["id"] = mysqli_insert_id($this->connection);
        }
        return $result;
    }

    public function getCourseModule($courseModuleID):array {
        $result = [
            "error" => True,
            "courseModuleID" => 0,
            "moduleID" => "",
            "lecturerID" => "",
            "startDate" => "",
            "endDate" => ""
        ];

        $sql = "SELECT * FROM course_module WHERE course_module_id = $courseModuleID;";
        $statement = mysqli_query($this->connection, $sql);
        $courseModule = mysqli_fetch_array($statement);
        if ($courseModule) {
            $result["courseModuleID"] = $courseModuleID;
            $result["moduleID"] = $courseModule["module_id"];
            $result["lecturerID"] = $courseModule["lecturer_id"];
            $result["startDate"] = $courseModule["start_date"];
            $result["endDate"] = $courseModule["end_date"];
            $result["error"] = False;
        }
        return $result;
    }

    public function updateCourseModule($courseModuleID, $lecturerID, $startDate, $endDate):array {
        $result = ["error" => True];

        $sql = "UPDATE course_module 
                SET lecturer_id = '$lecturerID', start_date = '$startDate', end_date = '$endDate'
                WHERE course_module_id = $courseModuleID";
        if (mysqli_query($this->connection, $sql)) {
            $result["error"] = False;
        }
        return $result;
    }

    public function deleteCourseModule($courseModuleID) {
        $result = ["error" => True];
        $sql = "DELETE FROM course_module WHERE course_module_id = $courseModuleID";
        if (mysqli_query($this->connection, $sql)) {
            $result["error"] = False;
        }
        return $result;
    }
}
?>