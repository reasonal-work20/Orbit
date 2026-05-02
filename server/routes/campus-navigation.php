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

function getLocation($data):array {
    global $mapController;
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

function getMap($condition):array {
    global $mapController, $navigateController;
    $mode = ["mode" => $condition["mode"]];
    $mapSvg = ["svg" => ""];

    switch ($mode["mode"]) {
        case "point":
            $floor = $condition["floor"];
            $mode["id"] = [$condition["point"]];
            $svg = $mapController->getMap($floor, $mode);
            $mapSvg["svg"] = $svg;
            break;
        
        case "route":
            $startData = $mapController->getNode($condition["start"]);
            $endData = $mapController->getNode($condition["end"]);
            $start = ["point" => $condition["start"], "floor" => $startData["floor"]];
            $end = ["point" => $condition["end"], "floor" => $endData["floor"]];
            $type = $condition["type"];

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
            $floor = $condition["floor"];
            $svg = $mapController->getMap($floor, $mode);
            $mapSvg["svg"] = $svg;
            break;
    }    
    return $mapSvg;
}
?>