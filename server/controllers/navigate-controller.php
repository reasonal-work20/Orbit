<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONFIG;
require_once ROOT . LOGIC . '/dijkstra.php';

class NavigateController {
    private $connection;

    public function __construct() {
        global $connect;
        $this->connection = $connect;
    }

    public function navigate($start, $end):array {
        if ($start["floor"] === $end["floor"]) {
            $path = dijkstra($start, $end);
        }

        return [];
    }

    private function graph($mode) {
        switch ($mode["mode"]) {
            case "floor":
                // Get data for a specific floor.
                break;
            case "connector":
                // Get data to search through connector connection.
                break;
            case "all":
                // Get data for all the connection.
        }

        return "";
    }
}
?>