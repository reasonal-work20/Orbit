<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.ROUTES.'/login.php';

$data = $_POST;
$result = login($data);
if ($result["error"]) {
    echo "Authentication fail<br/>";
    echo $result["message"];
} else {
    echo "Authentication pass<br/>";
    echo $result["role"];
    /**
     * Roles Output:
     * User Admin
     * Course Admin
     * Schedule Admin
     */
}
?>