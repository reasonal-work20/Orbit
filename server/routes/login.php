<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.CONFIG;
require_once ROOT.CONTROLLERS.'/authenticate.php';

/** 
* Login function that uses the authenticate function from the controller. 
* userID and role is set in the session for reusability.
* Function returns an associated array containing the error status and message.
*/

function login($data) {
    $email = $data["email"];
    $password = $data["password"];
    $verify = authenticate($email, $password);

    if ($verify["error"]) {
        return ["error" => True, "message" => $verify["message"]];
    } else {
        $_SESSION["userID"] = $verify["id"];
        $_SESSION["role"] = $verify["role"];
        return ["error" => False, "message" => ""];
    }
} 
?>