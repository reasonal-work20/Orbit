<?php
/**
* Class model of user.
*/

public class User() {
    private $connection;

    public function __construct($database) {
        $this->$connection = $database;
    }

    public function createUser($name, $password, $email, $phone, $profile, $role):array {
        $result = [
            "error" => True,
            "id" => 0
        ];

        $hashPassword = password_hash($password);
        $sql = "INSERT INTO user (name, password, email, phone, profile, role)
                VALUES ('$name', '$hashPassword', '$email', '$phone', '$profile', '$role');";
        if (mysqli_query($connection, $sql)) {
            $result["error"] = False;
            $result["id"] = mysqli_insert_id($connection);
        }

        return $result;
    }

    public function getUser($userID):array {
        $result = [
            "error" => False,
            "id" => $userID,
            "name" => "",
            "email" => "",
            "phone" => "",
            "profile" => ""
        ];

        $sql = "SELECT * FROM user WHERE user_id = $userID;";
        $statement = mysqli_query($connection, $sql);
        $user = mysqli_fetch_array($statement);
        if ($user) {
            $result["error"] = True;
            $result["name"] = $user["name"];
            $result["email"] = $user["email"];
            $result["phone"] = $user["phone"];
            $result["profile"] = $user["profile"];
        }

        return $result;
    }

    public function updateUser($userID, $name, $password, $email, $phone, $profile):array {
        $result = ["error" => True];

        $hashPassword = password_verify($password);
        $sql = "UPDATE user
                SET name = '$name', password = '$hashPassword', email = '$email', phone = '$phone', profile = '$profile'
                WHERE user_id = $userID;";
        if (mysqli_query($connection, $sql)) {
            $result["error"] = False;
        }

        return $result;
    }

    public function deleteUser($userID):array {
        $result = ["error" => True];

        $sql = "DELETE FROM user WHERE user_id = $userID;";
        if (mysqli_query($connection, $sql)) {
            $result["error"] = False;
        }

        return $result;
    }
}
?>