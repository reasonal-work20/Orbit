<?php
/**
* Class model of user.
* 
* User class constructor takes in the parameter database to establish connection to the database.
*
* Functions
* createUser    -> :param -> name, password, email, phone, picture picture file name, role
*               -> Returns an associated array containing the error status and id of the created user. 
*               -> Key -> [error, id]
*
* getUser       -> :param -> userID of the selected user.
*               -> Returns an associated array containing the error status and details of the selected user. 
*               -> Key -> [error, id, name, email, phone, picture, role]
*
* updateUser    -> :param -> userID of the user to be updated, name, password, email, phone, picture picture file name
*               -> Returns an associated array containing the error status. 
*               -> Key -> [error]
*
* deleteUser    -> :param -> userID of the user to be deleted.
*               -> Returns an associated array containing the error status. 
*               -> Key -> [error]
*/

class User {
    private $connection;

    public function __construct($database) {
        $this->connection = $database;
    }

    public function createUser($name, $password, $email, $phone, $picture, $role):array {
        $result = [];
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (name, password, email, phone, picture, role)
                VALUES ('$name', '$hashPassword', '$email', '$phone', '$picture', '$role');";
        try {
            mysqli_query($this->connection, $sql);
            $result["error"] = False;
            $result["id"] = mysqli_insert_id($this->connection);
        } catch (mysqli_sql_exception $e) {
            $result["error"] = True;
        }
        return $result;
    }

    public function getUser($userID):array {
        $result = [
            "error" => True,
            "id" => $userID,
            "name" => "",
            "password" => "",
            "email" => "",
            "phone" => "",
            "picture" => "",
            "role" => ""
        ];

        $sql = "SELECT * FROM user WHERE user_id = $userID;";
        $statement = mysqli_query($this->connection, $sql);
        $user = mysqli_fetch_array($statement);
        if ($user) {
            $result["error"] = False;
            $result["name"] = $user["name"];
            $result["password"] = $user["password"];
            $result["email"] = $user["email"];
            $result["phone"] = $user["phone"];
            $result["picture"] = $user["picture"];
            $result["role"] = $user["role"];
        }
        return $result;
    }

    public function updateUser($userID, $name, $password, $email, $phone, $picture):array {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user
                SET name = '$name', password = '$hashPassword', email = '$email', phone = '$phone'
                WHERE user_id = $userID;";
        try {
            mysqli_query($this->connection, $sql);
            if ($picture) {
                $sql = "UPDATE user SET picture = '$picture' WHERE user_id = $userID;";
            }
            mysqli_query($this->connection, $sql);
            $result = ["error" => False];
        } catch (mysqli_sql_exception $e) {
            $result = ["error" => True];
        }
        return $result;
    }

    public function deleteUser($userID):array {
        $sql = "DELETE FROM user WHERE user_id = $userID;";
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