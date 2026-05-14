<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.CONFIG;
require_once ROOT.CONTROLLERS.'/manage-user.php';

/**
* Functions in File
* getAllUser, getUser, createUser, updateUser, deleteUser
*/

$manageUser = new ManageUser();

function getAllUser($search) {
    global $manageUser;
    $data = $manageUser->getList($search);
    return $data;
}

function getUser($id) {
    global $manageUser;
    $data = $manageUser->get($id);
    return $data;
}

function createUser($inputData, $inputFile) {
    global $manageUser;
    $data = [
        "name" => $inputData["name"],
        "password" => $inputData["password"],
        "email" => $inputData["email"],
        "phone" => $inputData["phone"],
        "role" => $inputData["role"]
    ];
    if ($data["role"] === "Lecturer") {
        $data["qualification"] = $inputData["qualification"];
    }

    /** Creates a duplicate image file saved in the uploads folder. */
    if (isset($inputFile["picture"]) && $inputFile["picture"]["error"] === 0) {
        $extension = pathinfo($inputFile["picture"]["name"], PATHINFO_EXTENSION);
        $file = substr($data["name"], 0, 2) . "-" . time() . "." . $extension;
        $temp = $inputFile["picture"]["tmp_name"];
        $path = ROOT.UPLOADS."/".$file;
        copy($temp, $path);
        $data["picture"] = $file;
    } else {
        return "Error with the picture uploaded.";
    }

    $error = $manageUser->create($data);
    return $error;
}

function updateUser($inputData, $inputFile) {
    global $manageUser;
    $data = [
        "userID" => (int)$inputData["userID"],
        "name" => $inputData["name"],
        "password" => $inputData["password"],
        "email" => $inputData["email"],
        "phone" => $inputData["phone"],
        "role" => $inputData["role"],
        "status" => $inputData["status"]
    ];
    if ($data["role"] === "Lecturer") {
        $data["qualification"] = $inputData["qualification"];
    }

    /** Removes the old version of the image file and replaces it with a new file. */
    $user = $manageUser->get($data["userID"]);
    $data["picture"] = $user["picture"];
    if (isset($inputFile["picture"]) && $inputFile["picture"]["error"] === 0) {
        unlink(ROOT.UPLOADS."/".$data["picture"]);
        $extension = pathinfo($inputFile["picture"]["name"], PATHINFO_EXTENSION);
        $file = substr($data["name"], 0, 2) . "-" . time() . "." . $extension;
        $temp = $inputFile["picture"]["tmp_name"];
        $path = ROOT.UPLOADS."/".$file;
        move_uploaded_file($temp, $path);
        $data["picture"] = $file;
    }

    $error = $manageUser->update($data);
    return $error;
}

function deleteUser($inputData) {
    global $manageUser;
    $userData = $manageUser->get($inputData["userID"]);
    unlink(ROOT.UPLOADS."/".$userData["picture"]);
    $data = ["userID" => (int)$inputData["userID"]];
    $error = $manageUser->delete($data);
    return $error;
}
?>