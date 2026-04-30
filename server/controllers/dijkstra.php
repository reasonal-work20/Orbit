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
    $node = "";
    $distance = $temporary = $current = 0
}

/**
 * Start
 * Make final list table
 * Define all variable needed as preset
 * Loop
 *  > check if the previous is in the list
 *      > remove previous
 *      > check if there is still keys
 *          > find next key based on shortest distance
 *      *No next key, break loop
 *  > Get info on connected node
 *  > Check if better than already existing
 * Reverse find
 * Return path
 */
?>