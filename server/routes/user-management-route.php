<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.CONFIG;
require_once ROOT.CONTROLLERS;

$manageUser = new ManageUser();

function getAllUser($search) {
    $data = $manageUser->getList($search);
    return $data;
}

function getUser($id) {
    $data = $manageUser->get($id);
    return $data;
}

function createUser($inputData, $inputFile) {
    $data = [
        "name" => $inputData[""],
        "password" => $inputData[""],
        "email" => $inputData[""],
        "phone" => $inputData[""],
        "role" => $inputData[""]
    ];
    if ($data["role"] === "Lecturer") {
        $data["qualification"] = $inputData[""];
    }

    if (isset($inputFile[""]) && $inputFile[""]["error"] === 0) {
        $extension = pathinfo($inputFile[""]["name"], PATHINFO_EXTENSION);
        $file = $name . "-" . time() . $extension;
        $temp = $inputFile[""]["tmp_name"];
        $path = ROOT.UPLOADS."/".$file;
        move_uploaded_file($temp, $path);
        $data["picture"] = $file;
    } else {
        return "Error with the picture uploaded.";
    }

    $error = $manageUser->create($data);
    return $error;
}

function updateUser($inputData, $inputFile) {
    $data = [
        "userID" => $inputData[""],
        "name" => $inputData[""],
        "password" => $inputData[""],
        "email" => $inputData[""],
        "phone" => $inputData[""],
        "role" => $inputData[""],
        "status" => $inputData[""]
    ];
    if ($data["role"] === "Lecturer") {
        $data["qualification"] = $inputData[""];
    }

    if (isset($inputFile[""]) && $inputFile[""]["error"] === 0) {
        $extension = pathinfo($inputFile[""]["name"], PATHINFO_EXTENSION);
        $file = $name . "-" . time() . $extension;
        $temp = $inputFile[""]["tmp_name"];
        $path = ROOT.UPLOADS."/".$file;
        move_uploaded_file($temp, $path);
        $data["picture"] = $file;
    } else {
        $user = $manageUser->get($data["userID"]);
        $data["picture"] = $user["picture"];
    }

    $error = $manageUser->update($data);
    return $error;
}

function deleteUser($inputData) {
    $data = ["userID" => $inputData[""]];
    $error = $manageUser->delete($data);
    return $error;
}
?>