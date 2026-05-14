<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONFIG;
require_once ROOT . LOGIC . '/highlight-svg.php';

/**
* Map Controller
*
* Functions in the class
* getNodeList   -> Takes in an associated array used as filter and returns a list of nodes.
*               -> input array [floor, type]
*               -> modes [default, floor, search, type]
*
* getNode       -> Takes in the id of a location and returns the data of selected location. 
*
* getMap        -> Takes in an associated array and level. Returns a string svg. 
*               -> input array [mode, id], input level
*               -> mode [default, highlight]
*/

class MapController {
    public function getNodeList($search):array {
        global $connect;
        $result = [];

        if ($search["floor"] && $search["type"]) {
            $floor = $search["floor"];
            $type = $search["type"];
            $sql = "SELECT * FROM location WHERE floor = '$floor' AND type = '$type';";
        } elseif ($search["floor"]) {
            $floor = $search["floor"];
            $sql = "SELECT * FROM location WHERE floor = '$floor';";
        } elseif ($search["type"]) {
            $type = $search["type"];
            $sql = "SELECT * FROM location WHERE type = '$type';";
        } else {
            $sql = "SELECT * FROM location;";
        }

        $statement = mysqli_query($connect, $sql);
        while ($location = mysqli_fetch_array($statement)) {
            $data = [
                "locationID" => $location["location_id"],
                "name" => $location["name"],
                "floor" => $location["floor"],
                "type" => $location["type"]
            ];
            $result[] = $data;
        }

        return $result;
    }

    public function getNode($id) {
        global $connect;
        $result = ["name" => "", "floor" => "", "type" => ""];
        $sql = "SELECT * FROM location WHERE location_id = '$id';";
        $statement = mysqli_query($connect, $sql);
        $location = mysqli_fetch_array($statement);
        if ($location) {
            $result["name"] = $location["name"];
            $result["floor"] = $location["floor"];
            $result["type"] = $location["type"];
        }
        return $result;
    }

    public function getMap($level, $mode) {
        $svg = new DOMDocument();
        $svg->load(ROOT . DATA . "/map-l$level.svg");

        if ($mode["mode"] !== "default") {
            $nodeList = $this->getNodeList(["mode" => "floor", "floor" => $level, "type" => ""]);
            $nodeIdList = [];
            foreach ($nodeList as $row) {
                $nodeIdList[] = $row["locationID"];
            }
            alterSvg($svg, $nodeIdList, "#BEBEBE");
            alterSvg($svg, $mode["id"], "#180ED4");
        }

        return $svg->saveXML();
    }
}
?>