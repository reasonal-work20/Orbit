<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . MODELS . '/graph.php';
require_once ROOT . LOGIC . '/dijkstra.php';

/**
* :param > associated array:start, associated array:end, string:type
* array:start > [point, floor], array:end > [point, floor]
* string:type > option > [stair, elevator]
*
* Returns an associated array. [path, floor, distance]
*/

function sameFloorNavigate($start, $end, $type) {
    /** 
     * Get the checkpoints that the start and end point are connected to.
     * If no checkpoint was detected, assumption is made that the start or end point is a connector (elevator / staircase). 
     */
    $startCheckpoint = graph(["mode" => "room to checkpoint", "floor" => $start["floor"], "point" => $start["point"], "type" => $type]);
    $endCheckpoint = graph(["mode" => "room to checkpoint", "floor" => $end["floor"], "point" => $end["point"], "type" => $type]);
    if (!$startCheckpoint) {
        $startCheckpoint = [[$start["point"]], [0]];
    }
    if (!$endCheckpoint) {
        $endCheckpoint = [[$end["point"]], [0]];
    }

    /**
     * Go through all the possibilities to find the shortest route based on the combination of starting and ending checkpoints.
     */
    $graph = graph(["mode" => "checkpoint to checkpoint", "floor" => $start["floor"], "type" => $type]);
    $path = [];
    $distance = 99999;
    foreach ($startCheckpoint[0] as $point1) {
        foreach ($endCheckpoint[0] as $point2) {
            $result = dijkstra($point1, $point2, $graph);
            if ($result["distance"] < $distance) {
                $path = array_unique(array_merge([$start["point"]], $result["path"], [$end["point"]]));
                $path = array_values($path);
                $startIndex = array_search($point1, $startCheckpoint[0]);
                $endIndex = array_search($point2, $endCheckpoint[0]);
                $distance = $result["distance"] + $startCheckpoint[1][$startIndex] + $endCheckpoint[1][$endIndex];
                $floor = array_fill(0, count($path), $start["floor"]);
            }
        }
    }
    
    return ["path" => $path, "floor" => $floor, "distance" => $distance];
}

?>