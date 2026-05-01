<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONTROLLERS . '/map-controller.php';
require_once ROOT . CONTROLLERS . '/navigate-controller.php';

/**
* Functions in file
* getLocation
*/

$mapController = new MapController();
$navigateController = new NavigateController();

function getLocation($data):array {
    $mode["mode"] = $data["mode"];
    switch ($mode) {
        case "floor":
            $mode["floor"] = $data["floor"];
            break;
        case "search":
            $mode["search"] = $data["search"];
            break;
    }
    return $mapController->getNodeList($mode);
}
?>