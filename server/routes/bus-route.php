<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . MODELS . '/bus.php';

$bus = new Bus();

if (isset($_GET['fewSelectedRoute'])) {
    $result = $bus->getFew($_GET['fewSelectedRoute'], 9);
    echo json_encode([
        'start' => $result[0][0],
        'destination' => $result[0][1],
        'time' => $result[0][2]
    ]);
}

if (isset($_GET['all'])) {
    $result = $bus->getAll("All");
    echo json_encode(["schedule" => $result]);
}
?>