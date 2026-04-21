<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.CONFIG;

require_once ROOT.MODELS.'/user.php';
require_once ROOT.MODELS.'/student.php';
require_once ROOT.MODELS.'/lecturer.php';

/** 
* User management.
*/

public class ManageUser() {
    private $userEditor = new User();
    private $studentEditor = new User();
    private $lecturerEditor = new User();

    public function create(array $input, $role) {
        $error = True;
        
        $user = $userEditor.createUser($input["name"], $input["password"], $input["email"], $input["phone"], $input["profile"], $role);
        $error = $user["error"];
        if ($error) {
            return "Error has occurred when creating the user.";
        }

        switch ($role) {
            case "Student":
                $student = $studentEditor.createStudent($user["id"], $input["intakeGroupID"]);
                $error = $student["error"];
                break;
            case "Lecturer":
                $lecturer = $lecturerEditor.createLecturer($user["id"], $input["qualification"]);
                $error = $lecturer["error"];
                break;
        }
        
        if ($error) {
            return "Error has occurred when creating the user.";
        } else {
            return "";
        }
    }

    public function get($id, $role):array {
        $result = [
            "error" => True,
            "userID" => 0,
            "name" => "",
            "email" => "",
            "phone" => "",
            "profile" => ""
        ];

        $user = $userEditor.getUser($id);
        $result["error"] = $user["error"];
        if ($result["error"]) {
            return $result;
        } else {
            $result["userID"] = $user["id"];
            $result["name"] = $user["name"];
            $result["email"] = $user["email"];
            $result["phone"] = $user["phone"];
            $result["profile"] = $user["profile"];
        }

        switch ($role) {
            case "Student":
                $student = $studentEditor.getStudent($id);
                $result["error"] = $student["error"];
                if (!$result["error"]) {
                    $result["studentID"] = $student["studentID"];
                    $result["intakeGroupID"] = $student["intakeGroupID"];
                    $result["status"] = $student["status"];
                }
                break;
            case "Lecturer":
                $lecturer = $lecturerEditor.getLecturer($id);
                $result["error"] = $lecturer["error"];
                if (!$result["error"]) {
                    $result["lecturerID"] = $lecturer["lecturerID"];
                    $result["qualification"] = $lecturer["qualification"];
                    $result["status"] = $lecturer["status"];
                }
                break;
        }

        return $result;
    }

    public function update(array $input, $role) {
        $error = True;

        $user = $userEditor.updateUser($input["userID"], $input["name"], $input["password"], $input["email"], $input["phone"], $input["profile"]);
        $error = $user["error"];
        if ($error) {
            return "Error has occurred when updating the user.";
        }

        switch ($role) {
            case "Student":
                $student = $studentEditor.updateStudent($input["studentID"], $input["intakeGroupID"], $input["status"]);
                $error = $student["error"];
                break;
            case "Lecturer":
                $lecturer = $lecturerEditor.updateLecturer($input["lecturerID"], $input["qualification"], $input["status"]);
                $error = $lecturer["error"];
                break;
        }

        if ($error) {
            return "Error has occurred when updating the user.";
        } else {
            return "";
        }
    }

    public function delete(array $input) {
        $error = True;
        $user = $userEditor.deleteUser($input["userID"]);
        $error = $user["error"];
        if ($error) {
            return "Error has occurred when deleting the user.";
        } else {
            return "";
        }
    }
}
?>