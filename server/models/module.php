<?php
/**
* Class model of module.
*/

public class Module() {
    private $connection;

    public function __construct($connection) {
        $this->$connection = $connection;
    }

    public function createModule($majorID, $name, $short) {
        $result = [
            "error" => True,
            "id" => ""
        ];

        $sql = "INSERT INTO module (major_id, name) VALUES ($majorID, '$name');";
        if (mysqli_query($connection, $sql)) {
            $tempID = mysqli_insert_id($connection);
            $moduleID = "$tempID-$short";
            $sql = "UPDATE module SET module_id = '$moduleID' WHERE module_id = '$tempID';";
            if (mysqli_query($connection, $sql)) {
                $result["id"]  $moduleID;
                $result["error"] = False;
            }
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
        $statement = mysqli_query($connection, $sql);
        $module = mysqli_fetch_array($statement);
        if ($module) {
            $result["moduleID"] = $module["module_id"];
            $result["majorID"] = $module["major_id"];
            $result["name"] = $module["name"];
            $result["error"] = False;
        }
        
        return $result;
    }

    public function updateModule($moduleID, $majorID, $name) {
        $result = ["error" => True];
        $sql = "UPDATE module SET major_id = $majorID, name = '$name' WHERE module_id = '$moduleID';";
        if (!mysqli_query($connection, $sql)) {
            $result["error"] = False;
        }
        return $result;
    }

    public function deleteModule($moduleID) {
        $result = ["error" => True];
        $sql = "DELETE FROM module WHERE module_id = '$moduleID';";
        if (!mysqli_query($connection, $sql)) {
            $result["error"] = False;
        }
        return $result;
    }
}
?>