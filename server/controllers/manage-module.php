<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . MODELS . '/module.php';
require_once ROOT . CONFIG;

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
*                   -> Returns associated array. [error, moduleID, majorID, name]
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

    public function __construct() {
        global $connect;
        $this->connection = $connect;
        $this->moduleEditor = new Module($connect);
    }

    public function getMajorList() {
        $result = [];
        $sql = "SELECT * FROM major;";
        $statement = mysqli_query($this->connection, $sql);
        while ($row = mysqli_fetch_array($statement)) {
            $result[] = [$row["major_id"], $row["name"]];
        }
        return $result;
    }

    public function getModuleList($majorID) {
        $result = [];
        $sql = "SELECT * FROM module WHERE major_id = '$majorID';";
        $statement = mysqli_query($this->connection, $sql);
        while ($row = mysqli_fetch_array($statement)) {
            $result[] = [$row["module_id"], $row["name"]];
        }
        return $result;
    }

    public function getModule($moduleID):array {
        return $this->moduleEditor->getModule($moduleID);
    }

    public function createModule($input):array {
        $error = $this->moduleEditor->createModule($input["majorID"], $input["short"], $input["name"]);
        if ($error["error"]) {
            return "An error has occurred while creating the module. Please ensure the short code has not been used."; 
        }
        return "";
    }

    public function updateModule($input):array {
        $error = $this->moduleEditor->updateModule($input["moduleID"], $input["name"]);
        if ($error["error"]) {
            return "An error has occurred while updating the module name.";
        }
        return "";
    }

    public function deleteModule($moduleID):array {
        $error = $this->moduleEditor->deleteModule($moduleID);
        if ($error["error"]) {
            return "An error has occurred while deleting the module.";
        }
        return ""
    }
}
?>