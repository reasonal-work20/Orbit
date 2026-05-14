<?php
/**
 * Entry point for testing.
*/
require $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONTROLLERS . '/map-controller.php';
require_once ROOT . CONTROLLERS . '/navigate-controller.php';

$mapController = new MapController();
$navigateController = new NavigateController();
?>

<html>
<head>
    <title>Campus Navigation Test</title>
</head>

<body>
    <h1>Tests</h1>
    <?php
    $_GET['start'] = 'ST74';
    $_GET['end'] = 'ST83';
    $_GET['route'] = 'stair';
    $mode["mode"] = 'route';

    $startData = $mapController->getNode($_GET["start"]);
    $endData = $mapController->getNode($_GET["end"]);
    $start = ["point" => $_GET["start"], "floor" => $startData["floor"]];
    $end = ["point" => $_GET["end"], "floor" => $endData["floor"]];
    $type = $_GET["route"];

    $navigateResult = $navigateController->navigate($start, $end, $type);
    $path = $navigateResult["path"];
    $floor = $navigateResult["floor"];
    
    $idList = [];
    $pathName = [];
    for ($index = 0; $index < count($path); $index++) {
        if (array_key_exists($floor[$index], $idList)) {
            $idList[$floor[$index]][] = $path[$index];
        } else {
            $idList[$floor[$index]] = [$path[$index]];
        }

        $node = $mapController->getNode($path[$index]);
        if ($node["name"] !== "") {
            $pathName[] = $node["name"];
        } elseif (end($pathName) !== "Walk") {
            $pathName[] = "Walk";
        }
    }
    
    $mapSvg["svg"] = [];
    foreach ($idList as $floor => $id) {
        $x = $mapController->getMap($floor, ["mode" => $mode["mode"], "id" => $id]);
        $mapSvg["svg"][] = $mapController->getMap($floor, ["mode" => $mode["mode"], "id" => $id]);
    }
    $mapSvg["path"] = $pathName;
    echo json_encode($pathName);
    ?>
</body>
</html>