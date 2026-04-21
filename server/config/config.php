<?php
/**
* Connection configuration to the database.
* Creates a session if none has been created.
*/

$connect = mysqli_connect("localhost", "root", "");
if (!$connect) {
    die('Connection to database failed'. mysqli_connect_error());
}
mysqli_select_db($connect, 'orbit');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>