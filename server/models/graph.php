<?php
/** 
* Graph function returns the required data based on mode.
* :Parameters
* |- associated array 
*    |- model -> all, room to checkpoint, floor to floor, checkpoint to checkpoint
*    |- point -> for search the checkpoints connected to a certain point
*    |- floor -> specific floor
*
* Note about modes
* |- all => Returns table of connections for all points, checkpoints and connectors. (json)
* |- room to checkpoint => Returns the checkpoint connected to the specified point. Returns false if can't find. ([[checkpoint], [distance]])
* |- floor to floor => Returns list about the floor to floor connection. [[connection list], [floor order]]
* |- checkpoint to checkpoint => Returns table of connection between checkpoints. (json)
*/

function graph($mode) {
    $type = $mode["type"];
    $jsonString = file_get_contents(ROOT . DATA . "/connect-$type.json");
    $data = json_decode($jsonString, true);
    switch ($mode["mode"]) {
        case "all":
            $selectedData = $data["all"];
            break;
        case "room to checkpoint":
            $selectedData = $data["room-checkpoint"][$mode["floor"]];
            if (array_key_exists($mode["point"], $selectedData)) {
                $selectedData = $selectedData[$mode["point"]];
            } else {
                $selectedData = False;
            }
            break;
        case "floor to floor":
            $selectedData = $data["floor-floor"];
            break;
        case "checkpoint to checkpoint":
            $selectedData = $data["checkpoint-checkpoint"][$mode["floor"]];
            break;
    }
    return $selectedData;
}
?>