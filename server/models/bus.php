<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/Orbit/shared/constants.php';

class Bus {
    private $busData;

    public function __construct() {
        $jsonString = file_get_contents(ROOT . DATA . '/bus-shuttle.json');
        $this->busData = json_decode($jsonString, true);
    }

    public function getAll($type) {
        $result = [];
        if ($type === "All") {
            foreach ($this->busData as $key => $value) {
                $route = explode(" >> ", $key);
                $result[] = [$route[0], $route[1], $value];
            }
        } else {
            $route = explode(" >> ", $type);
            $data = $this->busData[$type];
            $result[] = [$route[0], $route[1], $data];
        }
        return $result;
    }

    public function getFew($type, $number) {
        $result = [];
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $time = time();
        if ($type === "All") {
            foreach ($this->busData as $key => $value) {
                $route = explode(" >> ", $key);
                $data = [];
                foreach ($value as $busTime) {
                    if ($time < strtotime($busTime)) {
                        $data[] = $busTime;
                    }
                }
                $result[] = [$route[0], $route[1], array_slice($data, 0, ($number - 1))];
            }
        } else {
            $route = explode(" >> ", $type);
            $allData = $this->busData[$type];
            $data = [];
            foreach ($allData as $busTime) {
                if ($time < strtotime($busTime)) {
                    $data[] = $busTime;
                }
            }
            $result[] = [$route[0], $route[1], array_slice($data, 0, ($number - 1))];
        }
        return $result;
    }
}
?>