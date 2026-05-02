<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.CONFIG;
require_once ROOT.MODELS.'/carpool.php';
require_once ROOT.MODELS.'/carpool-request.php';
require_once ROOT.CONTROLLERS.'/manage-user.php';

/**
* Carpool Controller
*
* Functions in the class
* getAvailable  -> Takes in an associated array and returns the list of available rides.
*               -> Input Keys [search, role, filter]
*               -> Output Keys [carpoolID, name, picture, hostID, time, start, destination, seat]
* 
* requester     -> Takes in the carpoolID and returns the details of a carpool ride for the requester pov.
*               -> Output Keys [carpoolID, name, picture, hostID, time, start, destination, seat, 
*                              carColour, carPlate, carModel, note, phone, email]
*
* host          -> Takes in the carpoolID and returns the details of a carpool ride for the host pov.
*               -> Output Keys [carpoolID, name, picture, hostID, time, start, destination, seat, 
*                  carColour, carPlate, carModel, note, requester]
*               -> Note that requester is a list in the format [[userID, name], [userID, name]]
* 
* getActive     -> Takes in userID and turns the status of the user and carpool ID.
*               -> Output Keys [host, requester, carpoolID]
*
* newRide       -> Takes in an associated array and returns error string.
*               -> [userID, type, start, destination, time, carColour, carPlate, carModel, capacity, note]
*
* cancelRide    -> Takes in an associated array and returns error string. 
*               -> [carpoolID]
*
* changeStatus  -> Takes in associated array and returns error string.
*               -> [carpoolID, status]
*
* approveRequest -> Takes in associated array and returns error string.
*                -> [carpoolID, approval]
*
* newRequest    -> Takes in associated array and returns error string.
*               -> [carpoolID, userID]
*
* cancelRequest -> Takes in associated array and returns error string.
*               -> [requestID]
*/

class CarpoolController {
    private $carpoolEditor;
    private $requestEditor;
    private $userEditor;

    public function __construct() {
        global $connect;
        $this->carpoolEditor = new Carpool($connect);
        $this->requestEditor = new CarpoolRequest($connect);
        $this->userEditor = new ManageUser();
    }

    public function getAvailable($input) {
        global $connect;
        $result = [];
        $search = $input["search"];
        $role = $input["role"];
        $filter = $input["filter"];

        if ($search) {
            $sql = "SELECT * FROM carpool c LEFT JOIN user u ON c.user_id = u.user_id
                    WHERE c.start LIKE '%$search$' OR c.destination LIKE '%$search%'
                    AND u.role = '$role' AND c.status = 'Waiting';";
        } elseif ($filter) {
            $sql = "SELECT * FROM carpool c LEFT JOIN user u ON c.user_id = u.user_id
                    WHERE c.type = '$filter' AND u.role = '$role' AND c.status = 'Waiting';";
        } else {
            $sql = "SELECT * FROM carpool c LEFT JOIN user u ON c.user_id = u.user_id
                    WHERE u.role = '$role' AND c.status = 'Waiting';";
        }
        $statement = mysqli_query($connect, $sql);
        while ($carpool = mysqli_fetch_array($statement)) {
            $userID = $carpool["user_id"];
            $carpoolID = $carpool["carpool_id"];
            $user = $this->userEditor->get($userID);
            if ($user["role"] === "Student") {
                $hostID = $user["studentID"];
            } elseif ($user["role"] === "Lecturer") {
                $hostID = $user["lecturerID"];
            }
            $sqlCapacity = "SELECT COUNT(carpool_id) AS capacity FROM carpool_request WHERE carpool_id = $carpoolID AND approval = 'Approved';";
            $statementCapacity = mysqli_query($connect, $sqlCapacity);
            $capacity = mysqli_fetch_array($statementCapacity);
            $remainderSeat = $carpool["capacity"] - $capacity['capacity'];
            
            $data = [
                "carpoolID" => $carpool["carpool_id"],
                "name" => $user["name"],
                "picture" => $user["picture"],
                "hostID" => $hostID,
                "time" => $carpool["time"],
                "start" => $carpool["start"],
                "destination" => $carpool["destination"],
                "seat" => $remainderSeat
            ];
            $result[] = $data;
        }
        return $result;
    }

    public function requester($carpoolID) {
        global $connect;
        $result = [];

        $sql = "SELECT * FROM carpool WHERE carpool_id = $carpoolID;";
        $statement = mysqli_query($connect, $sql);
        $carpool = mysqli_fetch_array($statement);
        if ($carpool) {
            $userID = $carpool["user_id"];
            $carpoolID = $carpool["carpool_id"];
            $user = $this->userEditor->get($userID);
            if ($user["role"] === "Student") {
                $hostID = $user["studentID"];
            } elseif ($user["role"] === "Lecturer") {
                $hostID = $user["lecturerID"];
            }
            $sqlCapacity = "SELECT COUNT(carpool_id) AS capacity FROM carpool_request WHERE carpool_id = $carpoolID AND approval = 'Approved';";
            $statementCapacity = mysqli_query($connect, $sqlCapacity);
            $capacity = mysqli_fetch_array($statementCapacity);
            $remainderSeat = $carpool["capacity"] - $capacity['capacity'];
            
            $data = [
                "carpoolID" => $carpool["carpool_id"],
                "name" => $user["name"],
                "picture" => $user["picture"],
                "hostID" => $hostID,
                "time" => $carpool["time"],
                "start" => $carpool["start"],
                "destination" => $carpool["destination"],
                "seat" => $remainderSeat,
                "carColour" => $carpool["car_colour"],
                "carPlate" => $carpool["car_plate"],
                "carModel" => $carpool["car_model"],
                "note" => $carpool["note"],
                "phone" => $user["phone"],
                "email" => $user["email"]
            ];
            $result[] = $data;
        }
        return $result;
    }

    public function host($carpoolID) {
        global $connect;
        $result = [];

        $sql = "SELECT * FROM carpool WHERE carpool_id = $carpoolID;";
        $statement = mysqli_query($connect, $sql);
        $carpool = mysqli_fetch_array($statement);
        if ($carpool) {
            $userID = $carpool["user_id"];
            $carpoolID = $carpool["carpool_id"];
            $user = $this->userEditor->get($userID);
            if ($user["role"] === "Student") {
                $hostID = $user["studentID"];
            } elseif ($user["role"] === "Lecturer") {
                $hostID = $user["lecturerID"];
            }
            $sqlCapacity = "SELECT COUNT(carpool_id) AS capacity FROM carpool_request WHERE carpool_id = $carpoolID AND approval = 'Approved';";
            $statementCapacity = mysqli_query($connect, $sqlCapacity);
            $capacity = mysqli_fetch_array($statementCapacity);
            $remainderSeat = $carpool["capacity"] - $capacity['capacity'];
            
            $sqlRequest = "SELECT * FROM carpool_request c
                            LEFT JOIN user u ON u.user_id = c.user_id
                            WHERE c.carpool_id = $carpoolID AND (c.approval = 'Pending' OR c.approval = 'Approved');";
            $statementRequest = mysqli_query($connect, $sqlRequest);
            $requester = [];
            while ($row = mysqli_fetch_array($statementRequest)) {
                $requester[] = [
                    "userID" => $row["user_id"],
                    "name" => $row["name"]
                ];
            }

            $data = [
                "carpoolID" => $carpool["carpool_id"],
                "name" => $user["name"],
                "picture" => $user["picture"],
                "hostID" => $hostID,
                "time" => $carpool["time"],
                "start" => $carpool["start"],
                "destination" => $carpool["destination"],
                "seat" => $remainderSeat,
                "carColour" => $carpool["car_colour"],
                "carPlate" => $carpool["car_plate"],
                "carModel" => $carpool["car_model"],
                "note" => $carpool["note"],
                "requester" => $requester
            ];
            $result[] = $data;
        };
        return $result;
    }

    public function getActive($userID):array {
        global $connect;
        $result = ["host" => False, "requester" => False, "carpoolID" => 0];
        $sql = "SELECT carpool_id FROM carpool WHERE user_id = '$userID';";
        $statement = mysqli_query($connect, $sql);
        $checkCarpool = mysqli_fetch_array($statement);
        if (!$checkCarpool) {
            $sql = "SELECT request_id FROM carpool_request WHERE user_id = '$userID';";
            $statement = mysqli_query($connect, $sql);
            $checkRequest = mysqli_fetch_array($statement);
            if (!$checkRequest) {
                return $result;
            }
            $result["requester"] = True;
            $result["carpoolID"] = $checkRequest["carpool_id"];
            return $result;
        }
        $result["host"] = True;
        $result["carpoolID"] = $checkCarpool["carpool_id"];
        return $result;
    }

    public function newRide(array $input):string {
        global $connect;
        $carpool = $this->carpoolEditor->createCarpool(
            $input["userID"], $input["type"],
            $input["start"], $input["destination"], $input["time"],
            $input["carColour"], $input["carPlate"], $input["carModel"],
            $input["capacity"], mysqli_real_escape_string($connect, $input["note"])
        );
        if ($carpool["error"]) {
            return "An error has occurred while creating this carpool ride.";
        } else {
            return "";
        }
    }

    public function cancelRide(array $input) {
        $error = $this->carpoolEditor->deleteCarpool($input["carpoolID"]);
        if ($error["error"]) {
            return "An error has occurred while cancelling ride.";
        } else {
            return "";
        }
    }

    public function changeStatus(array $input) {
        if ($input["status"] === "Completed") {
            $error = $this->carpoolEditor->deleteCarpool($input["carpoolID"]);
        } else {
            $error = $this->carpoolEditor->updateCarpool($input["carpoolID"], $input["status"]);
        }
        if ($error["error"]) {
            return "An error has occurred while updating the ride status.";
        } else {
            return "";
        }
    }

    public function approveRequest(array $input) {
        global $connect;
        $carpoolID = $input["carpoolID"];
        $carpool = $this->carpoolEditor->getCarpool($carpoolID);
        $sql = "SELECT COUNT(carpool_id) AS capacity FROM carpool_request WHERE carpool_id = $carpoolID AND approval = 'Approved';";
        $statement = mysqli_query($connect, $sql);
        $check = mysqli_fetch_array($statement);
        if ($check["capacity"] >= $carpool["capacity"] && $input["approval"] === "Approved") {
            return "The carpool has reached it's maximum capacity.";
        } else {
            $request = $this->requestEditor->updateRequest($input["requestID"], $input["approval"]);
            $check["capacity"] += 1;
            if ($request["error"]) {
                return "An error has occurred while updating the request.";
            } else {
                if ($check["capacity"] >= $carpool["capacity"]) {
                    $error = $this->changeStatus(["carpoolID" => $carpoolID, "status" => "Full"]);
                } 
                return "";
            }
        }
    }

    public function newRequest(array $input):string {
        global $connect;
        $carpoolID = $input["carpoolID"];
        $carpool = $this->carpoolEditor->getCarpool($carpoolID);
        if ($carpool["error"]) {
            return "An error has occurred when gathering data of the carpool ride.";
        }
        $sql = "SELECT COUNT(carpool_id) AS capacity FROM carpool_request WHERE carpool_id = $carpoolID AND approval='Approved';";
        $statement = mysqli_query($connect, $sql);
        $check = mysqli_fetch_array($statement);
        if ($check["capacity"] >= $carpool["capacity"]) {
            return "The carpool ride you want to request is already full.";
        }
        $request = $this->requestEditor->createRequest($input["userID"], $input["carpoolID"]);
        if ($request["error"]) {
            return "An error has occurred when creating the request.";
        } else {
            return "";
        }
    }

    public function cancelRequest(array $input):string {
        $error = $this->requestEditor->deleteRequest($input["requestID"]);
        if ($error["error"]) {
            return "An error has occurred while canceling the request.";
        } else {
            return "";
        }
    }
}
?>