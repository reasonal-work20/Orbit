<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . MODELS . '/bus.php';

$bus = new Bus();

function getAll($data) {
    $result = $bus->getAll($data);
    return $result;
}

function getFew($data) {
    $result = $bus->getFew($data["busRoute"], $data["number"]);
    return $result;
}
?>