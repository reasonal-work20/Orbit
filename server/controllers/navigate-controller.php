<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . LOGIC . '/dijkstra.php';
require_once ROOT . LOGIC . '/same-floor-navigate.php';
require_once ROOT . MODELS . '/graph.php';
require_once ROOT . CONTROLLERS . '/map-controller.php';

/**
* Note to change the json file.
* - Remove the start and end points in the floor-floor. Only leave the possible direct routes.
* 
* Navigate Controller
*
* Functions in class
* navigate  -> :param > start:associated array, end:associated array, type:string
*           -> array:start > keys > [point, floor]
*           -> array:end > keys > [point, floor]
*           -> string:type > options > [stair, elevator]
*/

class NavigateController {
    private $connection;

    public function navigate($start, $end, $type):array {
        /**
         * If statement used to filter conditions.
         * Condition 1 > Start and end point are on the same floor. Narrow down to identified floor.
         * Condition 2 > Identify a direct route between floors. The staircase / elevator that can reach the floor in a straight line.
         * If no path can be found, run dijkstra's algorithm on the entire mapping.
         */
        if ($start["floor"] === $end["floor"]) {
            $result = sameFloorNavigate($start, $end, $type);
            $path = $result["path"];
            $floor = $result["floor"];
        } else {
            $directFloor = graph(["mode" => "floor to floor", "type" => $type]);
            $connectorList = [[], []];
            foreach ($directFloor[1] as $rowIndex => $probableConnect) {
                if (!in_array($start["floor"], $probableConnect) || !in_array($end["floor"], $probableConnect)) {
                    continue;
                }
                $startIndex = array_search($start["floor"], $probableConnect);
                $endIndex = array_search($end["floor"], $probableConnect);
                if ($startIndex < $endIndex) {
                    $connectorList[0][] = $directFloor[0][$rowIndex][$startIndex];
                    $connectorList[1][] = $directFloor[0][$rowIndex][$endIndex];
                }
            }

            $path = [];
            $distance = 99999;
            foreach ($connectorList[0] as $checkConnector) {
                $index = array_search($checkConnector, $connectorList[0]);
                $connector1 = ["point" => $checkConnector, "floor" => $start["floor"]];
                $connector2 = ["point" => $connectorList[1][$index], "floor" => $end["floor"]];
                $graph1 = graph(["mode" => "checkpoint to checkpoint", "floor" => $start["floor"], "type" => $type]);
                $graph2 = graph(["mode" => "checkpoint to checkpoint", "floor" => $end["floor"], "type" => $type]);
                $part1 = sameFloorNavigate($start, $connector1, $type);
                $part2 = sameFloorNavigate($connector2, $end, $type);
                $total = $part1["distance"] + $part2["distance"];
                if ($total < $distance) {
                    $path = array_merge($part1["path"], $part2["path"]);
                    $distance = $total;
                    $floor = array_merge($part1["floor"], $part2["floor"]);
                }
            }
        }

        if (empty($path)) {
            $startCheckpoint = graph(["mode" => "room to checkpoint", "floor" => $start["floor"], "point" => $start["point"], "type" => $type]);
            $endCheckpoint = graph(["mode" => "room to checkpoint", "floor" => $end["floor"], "point" => $end["point"], "type" => $type]);
            if (!$startCheckpoint) {
                $startCheckpoint = $start['point'];
                $startDisplay = [];
            } else {
                $startCheckpoint = $startCheckpoint[0][0];
                $startDisplay = [$start['point']];
            }
            if (!$endCheckpoint) {
                $endCheckpoint = $end['point'];
                $endDisplay = [];
            } else {
                $endCheckpoint = $endCheckpoint[0][0];
                $endDisplay = [$end['point']];
            }

            $graph = graph(["mode" => "all", "type" => $type]);
            $result = dijkstra($startCheckpoint, $endCheckpoint, $graph);
            $path = array_merge($startDisplay, $result["path"], $endDisplay);
            $floor = [];
            $mapController = new MapController();
            foreach ($path as $node) {
                $detail = $mapController->getNode($node);
                if ($detail["floor"]) {
                    $floor[] = $detail["floor"];
                } else {
                    $floor[] = $floor[count($floor)-1];
                }
            }
        }
        return ["path" => $path, "floor" => $floor];
    }
}
?>