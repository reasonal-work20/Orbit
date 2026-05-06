<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONFIG;

$file = fopen(ROOT . '/Orbit/default-data/l4.txt', 'r');
if ($file) {
    while (($line = fgets($file)) !== false) {
        $cleanLine = str_replace(array("\r", "\n"), '', $line);
        $data = explode(',', $cleanLine);
        $locationID = $data[0];
        $name = $data[1];
        $floor = $data[2];
        $type = $data[3];
        $sql = "INSERT INTO location (location_id, name, floor, type) VALUES ('$locationID', '$name', '$floor', '$type');";
        if (!mysqli_query($connect, $sql)) {
            echo "Error:" . json_encode($cleanLine) . "<br/>";
        }
    }
    fclose($file);
} else {
    echo "Error";
}
?>