<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . MODELS . '/graph.php';
require_once ROOT . LOGIC . '/dijkstra.php';

/**
* start [floor, point]
* end [floor, point]
*/

function sameFloorNavigate($start, $end, $type) {
    $startCheckpoint = graph(["mode" => "room to checkpoint", "floor" => $start["floor"], "point" => $start["point"], "type" => $type]);
    $endCheckpoint = graph(["mode" => "room to checkpoint", "floor" => $end["floor"], "point" => $end["point"], "type" => $type]);
    if (!$startCheckpoint) {
        $startCheckpoint = [[$start["point"]], [0]];
    }
    if (!$endCheckpoint) {
        $endCheckpoint = [[$end["point"]], [0]];
    }

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