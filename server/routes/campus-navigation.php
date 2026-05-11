<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONTROLLERS . '/map-controller.php';
require_once ROOT . CONTROLLERS . '/navigate-controller.php';

/**
* Functions in file
* getLocation   -> Takes in an associated array and returns an array of data.
*               -> array:data > [mode, floor, search]
*               -> mode > [default, floor, search]
*               -> Return format [[locationID, name, floor]]
*
* getMap        -> Takes in an associated array and returns an associated array of data.
*               -> array:condition > [mode, floor, point, start, end, type]
*               -> mode > [point, route, default]
*               -> Return format [svg, path]
*/

$mapController = new MapController();
$navigateController = new NavigateController();

if (isset($_GET["getLocation"])) {
    global $mapController;
    $mode["mode"] = $_GET["mode"];
    switch ($mode) {
        case "floor":
            $mode["floor"] = $_GET["floor"];
            break;
        case "search":
            $mode["search"] = $_GET["search"];
            break;
    }
    $result = $mapController->getNodeList($mode);
    header('Content-Type: application/json');
    echo json_encode($result);
}

if (isset($_GET["getMap"])) {
    global $mapController, $navigateController;
    $mode = ["mode" => $_GET["mode"]];
    $mapSvg = ["svg" => ""];

    switch ($mode["mode"]) {
        case "point":
            $floor = $_GET["floor"];
            $mode["id"] = [$_GET["point"]];
            $svg = $mapController->getMap($floor, $mode);
            $mapSvg["svg"] = $svg;
            break;
        
        case "route":
            $startData = $mapController->getNode($_GET["start"]);
            $endData = $mapController->getNode($_GET["end"]);
            $start = ["point" => $_GET["start"], "floor" => $startData["floor"]];
            $end = ["point" => $_GET["end"], "floor" => $endData["floor"]];
            $type = $_GET["type"];

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
            break;
        
        default:
            $floor = $_GET["floor"];
            $svg = $mapController->getMap($floor, $mode);
            $mapSvg["svg"] = $svg;
            break;
    } 
    header('Content-Type: application/json');
    echo json_encode($mapSvg);
}
?>