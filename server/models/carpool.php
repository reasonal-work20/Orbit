<?php
/**
* Class model for carpool.
*
* Carpool class constructor takes in the parameter database to establish connection to the database.
* 
* Functions
* createCarpool -> :param -> userID, type, start, destination, time, car colour, car plate, car model, capacity, note
*               -> Returns an associated array containing the error status and id of the created carpool.
*               -> Key -> [error, id]
*
* getCarpool    -> :param -> id, referring to either carpoolID or userID
*               -> Returns an associated array containing the error status and the details of the selected carpool.
*               -> Key -> [error, type, start, destination, time, car colour, car plate, car model, capacity, note, status]
*
* updateCarpool -> :param -> carpoolID, status
*               -> Returns an associated array containing the error status. The function only updates the status of the carpool.
*               -> Key -> [error]
*
* deleteCarpool -> :param -> carpoolID
*               -> Returns an associated array containing the error status. 
*               -> Key -> [error]
*/

class Carpool {
    private $connection;

    public function __construct($database) {
        $this->connection = $database;
    }

    public function createCarpool($userID, $type, $start, $destination, $time, $carColour, $carPlate, $carModel, $capacity, $note):array {
        $result = [
            "error" => True,
            "id" => 0
        ];

        $sql = "INSERT INTO carpool (user_id, type, start, destination, time, car_colour, car_plate, car_model, capacity, note, status) 
                VALUES ($userID, '$type', '$start', '$destination', '$time', '$carColour', '$carPlate', '$carModel', $capacity, '$note', 'Waiting');";
        if (mysqli_query($this->connection, $sql)) {
            $result["id"] = mysqli_insert_id($this->connection);
            $result["error"] = False;
        }

        return $result;
    }

    public function getCarpool($id):array {
        $result = [
            "carpoolID" => 0,
            "userID" => 0,
            "error" => True,
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

        $sql = "SELECT * FROM carpool WHERE carpool_id = $id OR user_id = $id;";
        $statement = mysqli_query($this->connection, $sql);
        $carpool = mysqli_fetch_array($statement);
        if ($carpool) {
            $result["carpoolID"] = $carpool["carpool_id"];
            $result["userID"] = $carpool["user_id"];
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

    public function updateCarpool($carpoolID, $status):array {
        $result = ["error" => True];
        $sql = "UPDATE carpool SET status = '$status' WHERE carpool_id = $carpoolID;";
        if (mysqli_query($this->connection, $sql)) {
            $result["error"] = False;
        }
        return $result;
    }

    public function deleteCarpool($carpoolID):array {
        $result = ["error" => True ];
        $sql = "DELETE FROM carpool WHERE carpool_id = $carpoolID;";
        if (mysqli_query($this->connection, $sql)) {
            $result["error"] = False;
        }
        return $result;
    }
}
?>