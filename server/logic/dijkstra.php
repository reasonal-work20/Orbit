<?php
function dijkstra($start, $end, $graph) {
    /** Creates the table used to determine the final route.
     * | Node | Distance | Previous Node | */
    $allNodes = array_keys($graph);
    $table = [[], [], []];
    foreach ($allNodes as $node) {
        $table[0][] = $node;
        $table[2][] = "";
        if ($node === $start) {
            $table[1][] = 0;
        } else {
            $table[1][] = 99999;
        }
    }

    /** Preset value of variables before the loop. */
    $previous = $start;
    $next = "";

    /** Loop through to update the table. */
    while (true) {
        if (array_key_exists($previous, $graph) && empty($graph[$previous][0])) {
            unset($graph[$previous]);
            if (empty(array_keys($graph))) {
                break;
            }
            $allNodes = array_keys($graph);
            $check = 99999;
            foreach ($allNodes as $key) {
                $index = array_search($key, $table[0]);
                if ($table[1][$index] < $check) {
                    $check = $table[1][$index];
                    $next = $table[0][$index];
                }
            }
            if ($previous === $next) {
                break;
            } elseif (!empty($next)) {
                $previous = $next;
            }
            continue;
        }

        $node = $graph[$previous][0][0];
        $distance = $graph[$previous][1][0];
        $nodeIndex = array_search($node, $table[0]);
        $temporary = $table[1][$nodeIndex];
        $previousIndex = array_search($previous, $table[0]);
        $current = $distance + $table[1][$previousIndex];
        if ($current < $temporary) {
            $table[1][$nodeIndex] = $current;
            $table[2][$nodeIndex] = $previous;
        }
        unset($graph[$previous][0][0]);
        $graph[$previous][0] = array_values($graph[$previous][0]);
        unset($graph[$previous][1][0]);
        $graph[$previous][1] = array_values($graph[$previous][1]);
    }

    $finalPath = [$end];
    $distance = 0;
    $currentNode = $end;
    while (true) {
        if ($currentNode === $start) {
            break;
        }
        $index = array_search($currentNode, $table[0]);
        if ($index === false) {
            return [];
        }
        $currentNode = $table[2][$index];
        $finalPath[] = $currentNode;
    }
    $finalPath = array_reverse($finalPath);
    
    return $finalPath;
}
?>