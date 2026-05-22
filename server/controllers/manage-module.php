<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONFIG;
require_once ROOT . MODELS . '/module.php';
require_once ROOT . CONTROLLERS . '/manage-course-module.php';

/**
* Manage Module Controller
*
* Functions in the class
* getMajorList      -> Returns a list of all the majors. Format Regular Array > [[majorID, name], []]
* 
* getModuleList     -> Takes in the input majorID to filter for the modules within said major.
*                   -> Returns a list of all the modules in the selected major. Format Regular Array > [[moduleID, name], []]
*
* getModule         -> Takes in the input moduleID.
*                   -> Returns associated array. [error, moduleID, majorID, name, row] *Row refers to the number of course modules created.
*
* createModule      -> :param > majorID, short, name
*                   -> Returns error string.
*
* updateModule      -> :param > moduleID, name
*                   -> Returns error string.
*
* deleteModule      -> :param > moduleID
*                   -> Returns error string.
*/

class ManageCourse {
    private $connection;
    private $moduleEditor;
    private $courseModuleEditor;

    public function __construct() {
        global $connect;
        $this->connection = $connect;
        $this->moduleEditor = new Module($connect);
        $this->courseModuleEditor = new ManageCourseModule($connect);
    }

    public function getMajorList() {
        $result = [];
        $sql = "SELECT * FROM major;";
        $statement = mysqli_query($this->connection, $sql);
        while ($row = mysqli_fetch_array($statement)) {
            $result[] = ["majorID" => $row["major_id"], "name" => $row["name"]];
        }
        return $result;
    }

    public function getModuleList($majorID) {
        $result = [];
        if ($majorID) {
            $sql = "SELECT * FROM module WHERE major_id = '$majorID';";
        } else {
            $sql = "SELECT * FROM module;";
        }
        $statement = mysqli_query($this->connection, $sql);
        while ($row = mysqli_fetch_array($statement)) {
            $courseModuleList = $this->courseModuleEditor->getList($row["module_id"]);
            $result[] = ["moduleID" => $row["module_id"], "name" => $row["name"]];
        }
        return $result;
    }

    public function getModule($moduleID):array {
        $result = $this->moduleEditor->getModule($moduleID);
        if ($result["error"]) {
            return [];
        } else {
            $courseModuleList = $this->courseModuleEditor->getList($result["moduleID"]);
            return [
                "moduleID" => $result["moduleID"],
                "majorID" => $result["majorID"],
                "name" => $result["name"],
                "row" => count($courseModuleList)
            ];
        }
    }

    public function createModule($input):string {
        $error = $this->moduleEditor->createModule($input["majorID"], $input["name"], $input["short"]);
        if ($error["error"]) {
            return "An error has occurred while creating the module. Please ensure the short code has not been used."; 
        }
        return "";
    }

    public function updateModule($input):string {
        $error = $this->moduleEditor->updateModule($input["moduleID"], $input["name"]);
        if ($error["error"]) {
            return "An error has occurred while updating the module name.";
        }
        return "";
    }

    public function deleteModule($moduleID):string {
        $error = $this->moduleEditor->deleteModule($moduleID);
        if ($error["error"]) {
            return "An error has occurred while deleting the module.";
        }
        return "";
    }
}
?>