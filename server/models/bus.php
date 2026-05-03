<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/Orbit/shared/constants.php';

/**
* Bus class model
*
* Functions
* getAll    -> Takes in a string input used to search through the bus route.
*           -> Returns a list of data with all the scheduled bus time.
*
* getFew    -> Takes in a string input used to search through the bus route.
*           -> Takes in an integer input used to limit the number of scheduled bus time to return.
*/

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