<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . MODELS . '/course-module.php';
require_once ROOT . MODELS . '/module-intake.php';
require_once ROOT . MODELS . '/module-group.php';
require_once ROOT . MODELS . '/intake.php';
require_once ROOT . CONFIG;

/**
* Manage Course Controller
*
* Functions in class
* getList           -> :param > moduleID
*                   -> :output > array[[associated array], []]
*                   -> :output key > [courseModuleID, lecturerID, name, intake, startDate, endDate]
*
* getCourseModule   -> :param > courseModuleID
*                   -> :output > associated array [error, lecturerID, name, intake, startDate, endDate]
*
* getModuleGroup    -> :param > courseModuleID
*                   -> :output > array of intake ID
*
* createCourseModule -> :param > associated array [moduleID, lecturerID, startDate, endDate]
*                    -> :output > string error message
*
* createModuleGroup -> :param > associated array [courseModuleID, hours, type]
*                   -> :output > string error message
*
* updateCourseModule -> :param > associated array [courseModuleID, lecturerID, startDate, endDate]
*                    -> :output > string error message
*
* deleteCourseModule -> :param > courseModuleID
*                    -> :output > string error message
*
* deleteModuleGroup -> :param > associated array [courseModuleID, type]
*                   -> :output > string error message
*/

class ManageCourse {
    private $connection;
    private $courseModuleEditor;
    private $moduleIntakeEditor;
    private $moduleGroupEditor;
    private $intakeEditor;

    public function __construct() {
        global $connect;
        $this->connection = $connect;
        $this->courseModuleEditor = new CourseModule($connect);
        $this->moduleIntakeEditor = new ModuleIntake($connect);
        $this->moduleGroupEditor = new ModuleGroup($connect);
        $this->intakeEditor = new Intake($connect);
    }

    public function getList($moduleID):array {
        $result = [];
        $sql = "SELECT * FROM course_module c 
                LEFT JOIN lecturer l ON c.lecturer_id = l.lecturer_id
                LEFT JOIN user u ON l.user_id = u.user_id WHERE c.module_id = '$moduleID';";
        $statement = mysqli_query($this->connection, $sql);
        while ($row = mysqli_fetch_array($statement)) {
            $intakeList = $this->moduleIntakeEditor->getModuleIntake($row["course_module_id"]);
            $result[] = [
                "courseModuleID" => $row["course_module_id"], 
                "lecturerID" => $row["lecturer_id"],
                "name" => $row["name"],
                "intake" => $intakeList,
                "startDate" => $row["start_date"],
                "endDate" => $row["end_date"]
            ];
        }
        return $result;
    }

    public function getCourseModule($courseModuleID):array {
        $result = [
            "error" => True,
            "lecturerID" => "",
            "name" => "",
            "intake" => [],
            "startDate" => "",
            "endDate" => ""
        ];

        $sql = "SELECT * FROM course_module c
                LEFT JOIN lecturer l ON c.lecturer_id = l.lecturer_id
                LEFT JOIN user u ON u.user_id = l.user_id WHERE c.course_module_id = $courseModuleID;";
        $statement = mysqli_query($this->connection, $sql);
        $courseModule = mysqli_fetch_array($statement);
        if ($courseModule) {
            $result["lecturerID"] = $courseModule["lecturer_id"];
            $result["name"] = $courseModule["name"];
            $result["intake"] = $this->moduleIntakeEditor->getModuleIntake($courseModuleID);
            $result["startDate"] = $courseModule["start_date"];
            $result["endDate"] = $courseModule["end_date"];
            $result["error"] = False;
        }
        return $result;
    }

    public function getModuleGroup($courseModuleID) {
        $result = $this->moduleGroupEditor->getModuleGroup($courseModuleID);
        if ($result["error"]) {
            return [];
        } else {
            return $result["intakeID"];
        }
    }

    public function createCourseModule($input) {
        $courseModule = $this->courseModuleEditor->createCourseModule($input["moduleID"], $input["lecturerID"], $input["startDate"], $input["endDate"]);
        if ($courseModule["error"]) {
            return "An error has occurred.";
        }   
        foreach ($input["intakeID"] as $intakeID) {
            $error = $this->moduleIntakeEditor->createModuleIntake($intakeID, $courseModule["id"]);
            if ($error["error"]) {
                return "An error has occurred.";
            }
        }

        return $result;
    }

    public function createModuleGroup($input) {
        if ($type === "Lecture") {
            $error = $this->moduleGroupEditor->createModuleGroup($input["courseModuleID"], $input["hours"], $input["type"]);
            if ($error["error"]) {
                return "Error has occurred while creating the course module.";
            } else {
                return "";
            }
        }

        $courseModule = $this->moduleIntakeEditor->getModuleIntake($input["courseModuleID"]);
        if (empty($courseModule["intakeID"])) {
            return "No intakes found.";
        }

        $number = 0;
        foreach ($courseModule["intakeID"] as $intakeID) {
            $intakeData = $this->intakeEditor->getIntake($intakeID);
            $groupNumber = ceil($intakeData["total_register"] / 30);
            if ($groupNumber > $number) {
                $number = $groupNumber;
            }
        }
        if ($number === 0) {
            return "Not enough found.";
        }

        for ($index = 1, $index <= $number, $index++) {
            $this->moduleGroupEditor->createModuleGroup($input["courseModuleID"], $input["hours"], $input["type"]);
        }
        return "";
    }

    public function updateCourseModule($input) {
        $error = $this->courseModuleEditor->updateCourseModule($input["courseModuleID"], $input["lecturerID"], $input["startDate"], $input["endDate"]);
        if ($error["error"]) {
            return "An error has occurred.";
        } else {
            return "";
        }
    }

    public function deleteCourseModule($courseModuleID) {
        $error = $this->courseModuleEditor->deleteCourseModule($courseModuleID);
        if ($error["error"]) {
            return "An error has occurred.";
        } else {
            return "";
        }
    }

    public function deleteModuleGroup($input) {
        $moduleGroup = $this->moduleGroupEditor->getModuleGroup($input["courseModuleID"], $input["type"]);
        foreach ($moduleGroup as $row) {
            if ($row["type"] === $input["type"]) {
                $error = $this->moduleGroupEditor->deleteModuleGroup($row["moduleGroupID"]);
                if ($error["error"]) {
                    return "An error has occurred.";
                }
            }
        }
        return "";
    }
}
?>