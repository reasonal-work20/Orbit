<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONTROLLERS . '/carpool-controller.php';

$carpoolController = new CarpoolController();

function getCarpool($data) {
    global $carpoolController;
    $input = [
        "search" => $data["search"],
        "filter" => $data["filter"],
        "role" => $_SESSION["role"]
    ];
    $result = $carpoolController->getAvailable($input);
    return $result;
}

function requester($carpoolID) {
    global $carpoolController;
    $data = $carpoolController->requester($carpoolID);
    return $data;
}

function host($userID) {
    global $carpoolController;
    $data = $carpoolController->host($userID);
    return $data;
}

function getActive() {
    global $carpoolController;
    $data = $carpoolController->getActive($_SESSION["userID"]);
    return $data;
}

function newRide($data):string {
    global $carpoolController;
    $input = [
        "userID" => $_SESSION["userID"],
        "type" => $data["type"],
        "start" => $data["start"],
        "destination" => $data["destination"],
        "time" => $data["time"],
        "carColour" => $data["carColour"],
        "carPlate" => $data["carPlate"],
        "carModel" => $data["carModel"],
        "capacity" => $data["capacity"],
        "note" => $data["note"] 
    ];
    $error = $carpoolController->newRide($input);
    return $error;
}

function cancelRide($data):string {
    global $carpoolController;
    $error = $carpoolController->cancelRide($data);
    return $error;
}

function changeStatus($data):string {
    global $carpoolController;
    $error = $carpoolController->changeStatus($data);
    return $error;
}

function approveRequest($data):string {
    global $carpoolController;
    $error = $carpoolController->approveRequest($data);
    return $error;
}

function newRequest($data):string {
    global $carpoolController;
    $input = [
        "userID" => $_SESSION["userID"],
        "carpoolID" => $data["carpoolID"]
    ];
    $error = $carpoolController->newRequest($input);
    return $error;
}

function cancelRequest($data):string {
    global $carpoolController;
    $error = $carpoolController->cancelRequest($data);
    return $error;
}
?>