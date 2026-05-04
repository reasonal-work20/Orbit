<?php
/**
* Module Group class model
*
* Functions
* createModuleGroup -> :param >courseModuleID, hours, type
*                   -> Returns an associated array [error, id]
*
* getModuleGroup    -> :param > moduleGroupID
*                   -> Returns an associated array
*
* deleteModuleGroup -> :param > moduleGroupID
*                   -> Returns an associated array
*/

class ModuleGroup {
    private $connection;

    public function __construct($database) {
        $this->connection = $database;
    }

    public function createModuleGroup($courseModuleID, $hours, $type) {
        $result = ["error" => True, "id" => ""];
        $sql = "SELECT m.module_id, c.start_data FROM course_module c
                LEFT JOIN module m ON m.module_id = c.module_id
                WHERE c.course_module_id = $courseModuleID;";
        $statement = mysqli_query($this->connection, $sql);
        $courseModule = mysqli_fetch_array($statement);
        if (!$courseModule) {
            return $result;
        }

        $typeRepresentation = "";
        switch ($type) {
            case "Lecture":
                $typeRepresentation = "L";
                break;
            case "Tutorial":
                $typeRepresentation = "T";
                break;
            case "Lab":
                $typeRepresentation = "Lab";
        }
        $tempID = date("ym", strtotime($courseModule["start_date"])) . "-" . $courseModule["module_id"] . "-" . $typeRepresentation;

        $sql = "SELECT * FROM module_group;";
        $statement = mysqli_query($this->connection, $sql);
        $number = 1;
        while ($row = mysqli_fetch_array($statement)) {
            if (substr($row["module_group_id"], 0, strlen($tempID) - 1) === $tempID) {
                $number += 1;
            }
        }
        $moduleGroupID = $tempID . $number;

        $sql = "INSERT INTO module_group (module_group_id, course_module_id, hours, type)
                VALUES ('$moduleGroupID', $courseModuleID, $hours, $type);";
        if (mysqli_query($this->connection, $sql)) {
            $result["id"] = $moduleGroupID;
            $result["error"] = False;
        }
        return $result;
    }

    public function getModuleGroup($courseModuleID) {
        $result = [
            "error" => true, 
            "moduleGroup" => []
            ];
        $sql = "SELECT * FROM module_group WHERE course_module_id = ?;";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $courseModuleID);

        if ($stmt->execute()) {
            $result['error'] = false;
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $result['moduleGroup'][] = $row;
            }
        }
        $stmt->close();
        return $result;
    }

    // public function deleteModuleGroup($moduleGroupID):array {
    //     $result = ["error" => True];
    //     $sql = "DELETE FROM module_group WHERE module_group_id = '$moduleGroupID';";
    //     if (mysqli_query($this->connection, $sql)) {
    //         $result["error"] = False;
    //     }
    //     return $result;
    // }
}

?>