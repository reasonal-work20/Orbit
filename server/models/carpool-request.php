<?php
/**
* Carpool Request class model
*
* Carpool Request class constructor takes in database to establish connection to the database.
*
* Functions
* createRequest -> :param -> userID, carpoolID
*               -> Returns an associated array containing the error status and id of the created request.
*               -> Key -> [error, id]
*
* getRequest    -> :param -> id, referring to either requestID or userID
*               -> Returns an associated array containing the error status and the details about the request selected.
*               -> Key -> [error, requestID, userID, carpoolID, approval]
*
* updateRequest -> :param -> requestID, approval
*               -> Returns an associated array containing the error status. This function only updates the approval status.
*               -> Key -> [error]
*
* deleteRequest -> :param -> requestID
*               -> Returns an associated array containing the error status.
*               -> Key -> [error]
*/

class CarpoolRequest {
    private $connection;

    public function __construct($database) {
        $this->connection = $database;
    }

    public function createRequest($userID, $carpoolID):array {
        $sql = "INSERT INTO carpool_request (user_id, carpool_id, approval) VALUES ($userID, $carpoolID, 'Pending');";
        try {
            mysqli_query($this->connection, $sql);
            $result = ["error" => False, "id" => mysqli_insert_id($this->connection)];
        } catch (mysqli_sql_exception $e) {
            $result = ["error" => True];
        }
        return $result;
    }

    public function getRequest($id):array {
        $result = [
            "error" => True,
            "requestID" => 0,
            "userID" => 0,
            "carpoolID" => 0,
            "approval" => ""
        ];
        $sql = "SELECT * FROM carpool_request WHERE request_id = $id OR user_id = $id;";
        $statement = mysqli_query($this->connection, $sql);
        $request = mysqli_fetch_array($statement);
        if ($request) {
            $result["requestID"] = $request["request_id"];
            $result["userID"] = $request["user_id"];
            $result["carpoolID"] = $request["carpool_id"];
            $result["approval"] = $request["approval"];
            $result["error"] = False;
        }
        return $result;
    }

    public function updateRequest($requestID, $approval):array {
        $sql = "UPDATE carpool_request SET approval = '$approval' WHERE request_id = $requestID;";
        try {
            mysqli_query($this->connection, $sql);
            $result = ["error" => False];
        } catch (mysqli_sql_exception $e) {
            $result = ["error" => True];
        }
        return $result;
  }

    public function deleteRequest($requestID):array {
        $sql = "DELETE FROM carpool_request WHERE request_id = $requestID;";
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