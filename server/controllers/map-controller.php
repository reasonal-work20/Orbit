<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONFIG;
require_once ROOT . LOGIC . '/highlight-svg.php';

/**
* Map Controller
*
* Functions in the class
* getNodeList   -> Takes in an associated array used as filter and returns a list of nodes.
*               -> input array [mode, floor, search]
*               -> modes [default, floor, search]
*
* getNode       -> Takes in the id of a location and returns the data of selected location. 
*
* getMap        -> Takes in an associated array and level. Returns a string svg. 
*               -> input array [mode, id], input level
*               -> mode [default, highlight]
*/

class MapController {
    public function getNodeList($mode):array {
        global $connect;
        $result = [];

        switch ($mode["mode"]) {
            case "floor":
                $level = $mode["floor"];
                $sql = "SELECT * FROM location WHERE floor = '$level';";
                break;
            case "search":
                $search = $mode["search"];
                $sql = "SELECT * FROM location WHERE name LIKE '%$search%';";
                break;
            default:
                $sql = "SELECT * FROM location;";
                break;
        }
 
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

    public function getNode($id) {
        global $connect;
        $result = ["name" => "", "floor" => ""];
        $sql = "SELECT * FROM location WHERE location_id = '$id';";
        $statement = mysqli_query($connect, $sql);
        $location = mysqli_fetch_array($statement);
        if ($location) {
            $result["name"] = $location["name"];
            $result["floor"] = $location["floor"];
        }
        return $result;
    }

    public function getMap($level, $mode) {
        $svg = new DOMDocument();
        $svg->load(ROOT . DATA . "/map-l$level.svg");

        if ($mode["mode"] !== "default") {
            $nodeList = $this->getNodeList(["mode" => "floor", "floor" => $level]);
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