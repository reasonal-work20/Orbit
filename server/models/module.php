<?php
/**
* Class model of module.
*
* Functions
* createModule  -> :param > majorID, name, short
*               -> Returns associated array [error, id]
*
* getModule     -> :param > moduleID
*               -> Returns associated array [error, moduleID, majorID, name]
*
* updateModule  -> :param > moduleID, majorID, name
*               -> Returns associated array [error]
*
* deleteModule  -> :param > moduleID
*               -> Returns associated array [error]
*/

class Module {
    private $connection;

    public function __construct($database) {
        $this->connection = $database;
    }

    public function createModule($majorID, $name, $short) {
<<<<<<< HEAD
        $result = [];
        $moduleID = $majorID."-".$short;
        $sql = "INSERT INTO module (module_id, major_id, name) VALUES ('$moduleID', '$majorID', '$name');";
        try {
            mysqli_query($this->connection, $sql);
=======
        $result = [
            "error" => True,
            "id" => ""
        ];

        $moduleID = $majorID.$short;
        $sql = "INSERT INTO module (module_id, major_id, name) VALUES ($moduleID, $majorID, '$name');";
        if (mysqli_query($this->connection, $sql)) {
>>>>>>> d7f451b81f6ea5ee29a1102fc178643445ad3eaa
            $result["id"] = $moduleID;
            $result["error"] = False;
        } catch (mysqli_sql_exception $e) {
            $result["error"] = True;
        }
        return $result;
    }

    public function getModule($moduleID) {
        $result = [
            "error" => True,
            "moduleID" => "",
            "majorID" => 0,
            "name" => ""
        ];

        $sql = "SELECT * FROM module WHERE module_id = '$moduleID';";
        $statement = mysqli_query($this->connection, $sql);
        $module = mysqli_fetch_array($statement);
        if ($module) {
            $result["moduleID"] = $module["module_id"];
            $result["majorID"] = $module["major_id"];
            $result["name"] = $module["name"];
            $result["error"] = False;
        }
        
        return $result;
    }

    public function updateModule($moduleID, $name) {
        $sql = "UPDATE module SET name = '$name' WHERE module_id = '$moduleID';";
        try {
            mysqli_query($this->connection, $sql);
            $result = ["error" => False];
        } catch (mysqli_sql_exception $e) {
            $result = ["error" => True];
        }
        return $result;
    }

    public function deleteModule($moduleID) {
        $sql = "DELETE FROM module WHERE module_id = '$moduleID';";
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