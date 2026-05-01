<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONFIG;
require_once ROOT . LOGIC . '/highlight-svg.php';

class MapController {
    public function getNodeList($mode):array {
        global $connect;
        $result = [];

        if ($mode["mode"] === "default") {
            $sql = "SELECT * FROM location;";
        } elseif ($mode["mode"] === "level") {
            $level = $mode["level"];
            $sql = "SELECT * FROM location WHERE floor = '$level';";
        } elseif ($mode["mode"] === "search") {
            $search = $mode["search"];
            $sql = "SELECT * FROM location WHERE name LIKE '%$search%';";
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

    public function getMap($level, $mode) {
        $svg = new DOMDocument();
        $svg->load(ROOT . DATA . "/map-l$level.svg");

        if ($mode["mode"] !== "default") {
            $nodeList = $this->getNodeList(["mode" => "level", "level" => $level]);
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