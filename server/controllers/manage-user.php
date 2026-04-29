<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.CONFIG;

require_once ROOT.MODELS.'/user.php';
require_once ROOT.MODELS.'/student.php';
require_once ROOT.MODELS.'/lecturer.php';

/** 
* User Management Controller
*
* Functions in the class
* create    -> Creates new user, either student or lecturer. Takes in an associated array input and role input. Return any string of error.
*           -> [name, password, email, phone, picture, qualification] *Qualification only applicable for lecturer role.
*
* getList   -> Takes in a string input to filter through the data. Input is optional. Returns a list of user data.
*           -> [userID, name, password, email, phone, picture, role]
*
* get       -> Takes in id input of the selected user. Returns data of the selected user.
*           -> [userID, name, password, email, phone, picture, role, lecturerID, qualification, studentID, status]
*
* update    -> Updates the current user. Takes in an associated array input and role input. Return any string of error.
*           -> [userID, name, password, email, phone, picture, role, qualification, status]
*
* delete    -> Takes in id input of the selected user and deletes said user. Returns any string of error.
*/

class ManageUser {
    private $userEditor;
    private $studentEditor;
    private $lecturerEditor;

    public function __construct() {
        global $connect;
        $this->userEditor = new User($connect);
        $this->studentEditor = new Student($connect);
        $this->lecturerEditor = new Lecturer($connect);
    }

    public function create(array $input, $role):string {
        $error = True;
        
        $user = $this->userEditor->createUser($input["name"], $input["password"], $input["email"], $input["phone"], $input["picture"], $role);
        $error = $user["error"];
        if ($error) {
            return "Error has occurred when creating the user.";
        }

        switch ($role) {
            case "Student":
                $student = $this->studentEditor->createStudent($user["id"]);
                $error = $student["error"];
                break;
            case "Lecturer":
                $lecturer = $this->lecturerEditor->createLecturer($user["id"], $input["qualification"]);
                $error = $lecturer["error"];
                break;
        }
        
        if ($error) {
            return "Error has occurred when creating the user.";
        } else {
            return "";
        }
    }

    public function getList($search):array {
        global $connect;
        $result = [];
        
        if ($search) {
            $sql = "SELECT * FROM user
                    WHERE name LIKE '%$search%'
                    AND role != 'User Admin' AND role != 'Course Admin' AND role != 'Schedule Admin';";
        } else {
            $sql = "SELECT * FROM user WHERE role != 'User Admin' AND role != 'Course Admin' AND role != 'Schedule Admin';";
        }
        $statement = mysqli_query($connect, $sql);
        while ($user = mysqli_fetch_array($statement)) {
            $data = [
                "userID" => $user["user_id"],
                "name" => $user["name"],
                "password" => $user["password"],
                "email" => $user["email"],
                "phone" => $user["phone"],
                "picture" => $user["picture"],
                "role" => $user["role"]
            ];
            $result[] = $data;
        }

        return $result;
    }

    public function get($id):array {
        $result = [
            "error" => True,
            "userID" => 0,
            "name" => "",
            "password" => "",
            "email" => "",
            "phone" => "",
            "picture" => "",
            "role" => ""
        ];

        $user = $this->userEditor->getUser($id);
        $result["error"] = $user["error"];
        if ($result["error"]) {
            return $result;
        } else {
            $result["userID"] = $user["id"];
            $result["name"] = $user["name"];
            $result["password"] = $user["password"];
            $result["email"] = $user["email"];
            $result["phone"] = $user["phone"];
            $result["picture"] = $user["picture"];
            $result["role"] = $user["role"];
            $role = $user["role"];
        }

        switch ($role) {
            case "Student":
                $student = $this->studentEditor->getStudent($id);
                $result["error"] = $student["error"];
                if (!$result["error"]) {
                    $result["studentID"] = $student["studentID"];
                    $result["status"] = $student["status"];
                }
                break;
            case "Lecturer":
                $lecturer = $this->lecturerEditor->getLecturer($id);
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

    public function update(array $input, $role):string {
        $error = True;

        $user = $this->userEditor->updateUser($input["userID"], $input["name"], $input["password"], $input["email"], $input["phone"], $input["picture"]);
        $error = $user["error"];
        if ($error) {
            return "Error has occurred when updating the user.";
        }

        switch ($role) {
            case "Student":
                $student = $this->studentEditor->updateStudent($input["studentID"], $input["status"]);
                $error = $student["error"];
                break;
            case "Lecturer":
                $lecturer = $this->lecturerEditor->updateLecturer($input["lecturerID"], $input["qualification"], $input["status"]);
                $error = $lecturer["error"];
                break;
        }

        if ($error) {
            return "Error has occurred when updating the user.";
        } else {
            return "";
        }
    }

    public function delete(array $input):string {
        $error = True;
        $user = $this->userEditor->deleteUser($input["userID"]);
        $error = $user["error"];
        if ($error) {
            return "Error has occurred when deleting the user.";
        } else {
            return "";
        }
    }
}
?>