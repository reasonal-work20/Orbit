<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.ROUTES.'/user-management-route.php';

/**
 * !! IMPORTANT !!
 * HTML Name on Inputs
 * name, password, email, phone, picture, role, studentID, lecturerID, qualification, status
 */

if (isset($_POST[""])) {
    $error = createUser($_POST, $_FILES);
    /** Return value of error is a string value. "" means no error occurred. */
}

if (isset($_POST[""])) {
    $error = updateUser($_POST, $_FILES);
    /** Return value of error is a string value. "" means no error occurred. */
}

if (isset($_POST[""])) {
    $error = deleteUser($_POST);
    /** Return value of error is a string value. "" means no error occurred. */
}

/**
 * getAllUser($search)  -> $search is string keyword to search through user's name
 *                      -> Array looks like [[], [], []]
 *                      -> Each array in an array is an associated array.
 *                      -> Key -> [error, userID, name, password, email, phone, picture, role, studentID, lecturerID, qualification, status]
 * 
 * getUser($id)         -> get data of one user.
 *                      -> Array return is an associated array.
 *                      -> Key -> [error, userID, name, password, email, phone, picture, role, studentID, lecturerID, qualification, status]
 */
?>