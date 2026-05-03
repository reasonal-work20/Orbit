<?php
/**
* Class model for module intake
*
* Functions
* createModuleIntake    -> :param > intakeID, courseModuleID
*                       -> Returns an associated array [error, id]
*
* getModuleIntake       -> :param > courseModuleID
*                       -> Returns an associated array [error, intakeID] *Note intakeID is a list.
*
* deleteModuleIntake    -> :param > moduleIntakeID
*                       -> Returns an associated array [error]
*/

class ModuleIntake {
    private $connection;

    public function __construct($database) {
        $this->connection = $database;
    }

    public function createModuleIntake($intakeID, $courseModuleID) {
        $result = ["error" => True, "id" => 0];
        $sql = "INSERT INTO module_intake (intake_id, course_module_id) VALUES ('$intakeID', '$courseModuleID');";
        if (mysqli_query($this->connection, $sql)) {
            $result["id"] = mysqli_insert_id($this->connection);
            $result["error"] = False;
        }
        return $result;
    }

    public function getModuleIntake($courseModuleID):array {
        $result = ["error" => True, "intakeID" => []];
        $sql = "SELECT * FROM module_intake WHERE course_module_id = $courseModuleID;";
        $statement = mysqli_query($this->connection, $sql);
        $moduleIntake = mysqli_fetch_array($statement);
        if ($moduleIntake) {
            $result["intakeID"][] = $moduleIntake["intake_id"];
            $result["error"] = False;
        }
        return $result;
    }

    public function deleteModuleIntake($moduleIntakeID):array {
        $result = ["error" => True];
        $sql = "DELETE FROM module_intake WHERE module_intake_id = $moduleIntakeID;";
        if (mysqli_query($this->connection, $sql)) {
            $result["error"] = False;
        }
        return $result;
    }
}
?>