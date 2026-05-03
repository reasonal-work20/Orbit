<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . MODELS . '/intake.php';
require_once ROOT . MODELS . '/student-intake.php';
require_once ROOT . CONFIG;

class ManageIntake {
    private $connection;
    private $intakeEditor;
    private $studentIntakeEditor;

    public function __construct() {
        global $connect;
        $this->connection = $connect;
        $this->intakeEditor = new Intake($connect);
        $this->studentIntakeEditor = new StudentIntake($connect);
    }

    public function createIntake($input) {
        $error = $this->intakeEditor->createIntake($input["courseID"], $input["name"], $input["short"], $input["startDate"]);
        if ($error["error"]) {
            return "An error has occurred while creating the intake.";
        } else {
            return "";
        }
    }

    public function addStudent($input) {
        $error = $this->studentIntakeEditor->create($input["studentID"], $input["intakeID"]);
        if ($error["error"]) {
            return "An error has occurred while enrolling the student.";
        } else {
            return "";
        }
    }

    public function getIntakeList($search) {
        $result = [];
        if ($search === "") {
            $sql = "SELECT * FROM intake;";
        } else {
            $sql = "SELECT * FROM intake WHERE name LIKE '%$search%';";
        }

        $statement = mysqli_query($this->connection, $sql);
        while ($intake = mysqli_fetch_array($statement)) {
            $result[] = [
                $intake["intakeID"], 
                $intake["courseID"],
                $intake["name"],
                $intake["startDate"],
                $intake["totalRegister"],
                $intake["status"]
            ]
        }

        $result;
    }

    public function getIntake($intakeID) {
        $result = $this->intakeEditor->getIntake($intakeID);
        if ($error["error"]) {
            return [];
        } else {
            return [
                "intakeID" => $result["intakeID"], 
                "courseID" => $result["courseID"],
                "name" => $result["name"],
                "startDate" => $result["startDate"],
                "totalRegister" => $result["totalRegister"],
                "status" => $result["status"]];
        }
    }

    public function getStudentList($intakeID) {
        $result = [];
        $sql = "SELECT * FROM student_intake WHERE intake_id = '$intakeID';";
        $statement = mysqli_query($this->connection, $sql);
        while ($row = mysqli_fetch_array($statement)) {
            $result[] = [
                "studentIntakeID" => $row["student_intake_id"],
                "studentID" => $row["student_id"],
                "intakeID" => $row["intake_id"]
            ];
        }
        return $result;
    }

    public function getStudent($search) {
        $result = [];
        $sql = "SELECT * FROM student_intake_id i
                LEFT JOIN student s ON s.student_id = i.student_id
                LEFT JOIN user u ON s.user_id = u.user_id
                WHERE u.name LIKE '%$search%';";
        $statement = mysqli_query($this->connection, $sql);
        while ($row = mysqli_fetch_array($statement)) {
            $result[] = [
                "studentIntakeID" => $row["student_intake_id"],
                "studentID" => $row["student_id"],
                "intakeID" => $row["intake_id"],
                "name" => $row["name"]];
        }
        return $result;
    }

    public function updateIntake($input) {
        $error = $this->intakeEditor->updateIntake($input["intakeID"], $input["startDate"], $input["status"]);
        if ($error["error"]) {
            return "An error has occurred.";
        } else {
            return "";
        }
    }

    public function deleteIntake($intakeID) {
        $error = $this->intakeEditor->deleteIntake($intakeID);
        if ($error["error"]) {
            return "An error has occurred";
        } else {
            return "";
        }
    }

    public function deleteStudent($studentIntakeID) {
        $error = $this->studentIntakeEditor->delete($studentIntakeID);
        if ($error["error"]) {
            return "An error has occurred while removing the student from the intake";
        } else {
            return "";
        }
    }
}
?>