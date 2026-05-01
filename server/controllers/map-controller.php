<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONFIG;
require_once ROOT . LOGIC . '/highlight-svg.php';

class MapController {
    public function getMap($level, $mode, $idList, $highlight) {
        $svg = new DOMDocument();
        $svg->load(ROOT . DATA . "/map-l$level.svg");
        return $svg->saveXML();
    }

    public function getLevelNode($level):array {
        global $connect;
        $result = [];

        $sql = "SELECT * FROM location WHERE floor = '$level';";
        $statement = mysqli_query($connect, $sql);
        while ($location = mysqli_fetch_array($statement)) {
            $data = [
                "locationID" => $location["location_id"],
                "name" => $location["name"],
                "floor" => $location["floor"]
            ];
            $result[] = $data;
        }

        return $result;
    }
}
?>