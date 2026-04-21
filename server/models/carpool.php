<?php
/**
* Class model for Carpool.
*/

public class Carpool() {
    private $connection;

    public function __construct($connection) {
        $this->$connection = $connection;
    }

    public function createCarpool($userID, $type, $start, $destination, $time, $carColour, $carPlate, $carModel, $capacity, $note) {
        $result = [
            "error" => True,
            "id" => 0
        ];

        $sql = "INSERT INTO carpool (user_id, type, start, destination, time, car_colour, car_plate, car_model, capacity, note, status)
                VALUES ($userID, '$type', '$start', '$destination', '$time', '$carColour', '$carPlate', '$carModel', $capacity, '$note', 'Open');";
        if (mysqli_query($connection, $sql)) {
            $result["id"] = mysqli_insert_id($connection);
            $result["error"] = False;
        }

        return $result;
    }

    public function createRequest($carpoolID, $userID) {
        $result = [
            "error" => True,
            "id" => 0
        ];

        $sql = "SELECT capacity FROM carpool WHERE carpool_id = $carpoolID;";
        $statement = mysqli_query($connection, $sql);
        $carpool = mysqli_fetch_array($statement);
        if (!$carpool) {
            return $result;
        }
        $sql = "SELECT COUNT(request_id) AS total FROM carpool_request WHERE carpool_id = $carpoolID;";
        $statement = mysqli_query($connection, $sql);
        $capacity = mysqli_fetch_array($statement);
        if (!$capacity || $capacity["total"] >= $carpool["capacity"]) {
            return $result;
        } 

        $sql = "INSERT INTO carpool_request (user_id, carpool_id, approval) VALUES ($userID, $carpoolID, 'Pending');";
        if (mysqli_query($connection, $sql)) {
            $result["id"] = mysqli_insert_id($connection);
            $result["error"] = False;
        }

        return $result;
    }

    public function getCarpool($carpoolID) {
        $result = [
            "error" => True,
            "id" => 0,
            "type" => "",
            "start" => "",
            "destination" => "",
            "time" => "",
            "carColour" => "",
            "carPlate" => "",
            "carModel" => "",
            "capacity" => 0,
            "note" => "",
            "status" => ""
        ];

        $sql = "SELECT * FROM carpool WHERE carpool_id = $carpoolID;";
        $statement = mysqli_query($connection, $sql);
        $carpool = mysqli_fetch_array($statement);
        if ($carpool) {
            $result["id"] = $carpool["carpool_id"];
            $result["type"] = $carpool["type"];
            $result["start"] = $carpool["start"];
            $result["destination"] = $carpool["destination"];
            $result["time"] = $carpool["time"];
            $result["carColour"] = $carpool["car_colour"];
            $result["carPlate"] = $carpool["car_plate"];
            $result["carModel"] = $carpool["car_model"];
            $result["capacity"] = $carpool["capacity"];
            $result["note"] = $carpool["note"];
            $result["status"] = $carpool["status"];
            $result["error"] = False;
        }
        return $result;
    }

    public function getRequest($carpoolID) {
        $result = ["error" => True];
        $sql = "SELECT * FROM carpool_request WHERE carpool_id = $carpoolID;";
    }

    public function updateCarpool($carpoolID, $type, $start, $destination, $time, $carColour, $carPlate, $carModel, $capacity, $note, $status) {
        $result = ["error" => True];
        $sql = "UPDATE carpool
                SET type = '$type', start = '$start', destination = '$destination',
                car_colour = '$carColour', car_plate = '$carPlate', car_model = '$carModel', 
                capacity = $capacity, note = '$note', status = '$status'
                WHERE carpool_id = $carpoolID";
        if (mysqli_query($connection, $sql)) {
            $result["error"] = False;
        }
        return $result;
    }

    public function updateRequest($requestID, $approval) {
        $result = ["error" => True];
        $sql = "UPDATE carpool_request SET approval = '$approval' WHERE request_id = $requestID;";
        if (mysqli_query($connection, $sql)) {
            $result["error"] = False;
        }
        return $result;
    }

    public function deleteCarpool($carpoolID) {
        $result = ["error" => True];
        $sql = "DELETE FROM carpool WHERE carpool_id = $carpoolID;";
        if (mysqli_query($connection, $sql)) {
            $result["error"] = False;
        }
        return $result;
    }

    public function deleteRequest($requestID) {
        $result = ["error" => True];
        $sql = "DELETE FROM carpool_request WHERE request_id = $requestID;";
        if (mysqli_query($connection, $sql)) {
            $result["error"] = False;
        }
        return $result;
    }
}
?>