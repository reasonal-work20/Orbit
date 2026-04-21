<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.CONFIG;

/**
* Login Authentication
* Takes in the Parameters
* | email -> string
* | password -> string
* 
* Returns
* | associative array data type
* | keys: error -> bool, role -> string
*/

public function authenticate($email, $password):array {
    // Default return result.
    $result = [
        "error" => True,
        "message" => "",
        "id" => "",
        "role" => ""
    ];

    $sql = "SELECT user_id, password, role FROM user WHERE email = '$email';";
    $statement = mysqli_query($connect, $sql);
    $user = mysqli_fetch_array($statement);
    if (!$user) {
        $result["message"] = "Incorrect email / password. Please try again.";
    } elseif (!password_verify($pass, $user['password'])) {
        $result["message"] = "Incorrect email / password. Please try again.";
    } else {
        $result["error"] = False
        $result["id"] = $user["user_id"];
        $result["role"] = $user["role"];
    }

    return $result;
}
?>