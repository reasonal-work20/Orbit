<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONTROLLERS . '/map-controller.php';
require_once ROOT . CONTROLLERS . '/navigate-controller.php';

$mapController = new MapController();
$navigateController = new NavigateController();

$start = $_GET["start"];
$end = $_GET["end"];
$startNode = $mapController->getNode($start);
$endNode = $mapController->getNode($end);

$startData = [
    "point" => $start,
    "floor" => $startNode["floor"]
];
$endData = [
    "point" => $end,
    "floor" => $endNode["floor"]
];

$result = $navigateController->navigate($startData, $endData, "elevator");
if (empty($result["path"])) {
    $success = false;
} else {
    $success = true;
}
header('Content-Type: application/json');
echo json_encode(["result" => $success]);
?>