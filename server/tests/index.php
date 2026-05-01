<?php
/**
 * Entry point for testing.
*/
require $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.CONTROLLERS.'/navigate-controller.php';
require_once ROOT.CONTROLLERS.'/map-controller.php';
require_once ROOT.LOGIC.'/same-floor-navigate.php';
?>

<html>
<head>
    <title>Tests</title>
</head>

<body>
    <h1>Tests</h1>
    <?php
    $test = new NavigateController();
    $file = fopen(ROOT. '/Orbit/server/tests/all.txt', 'r');
    $testData = [];
    $floorData = [];
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $cleanLine = str_replace(array("\r", "\n"), '', $line);
            $data = explode(',', $cleanLine);
            $testData[] = $data[0];
            $floorData[] = $data[2];
        }
    }

    function factorial($x) {
        $result = 1;
        for ($i = 1; $i <= $x; $i++) {
            $result *= $i;
        }
        return $result;
    }

    $n = count($testData) + 1;
    $total = factorial($n) / (factorial(2) * factorial($n-2));

    $success = 0;
    $fail = [];
    $startIndex = $endIndex = 0;
    while ($startIndex < count($testData)) {
        $start = ["point" => $testData[$startIndex], "floor" => $floorData[$startIndex]];
        while ($endIndex < count($testData)) {
            $end = ["point" => $testData[$endIndex], "floor" => $floorData[$endIndex]];
            if (substr($start["point"], 0, 2) === "EV") {
                $start["point"] = str_replace("EV", "ST", $start["point"]);
            }
            if (substr($end["point"], 0, 2) === "EV") {
                $end["point"] = str_replace("EV", "ST", $end["point"]);
            }

            $result = $test->navigate($start, $end, "stair");
            if ($result["path"]) {
                $success += 1;
                echo $start["point"] . " -> " . $end["point"] . " | Success | <br/>";
            } else {
                $fail[] = $start["point"] . " -> " . $end["point"];
            }
            $endIndex += 1;
        }
        $startIndex += 1;
        $endIndex = $startIndex;
    }

    echo "<br/>Result<br/>" . $success . "/" . $total;

    // $forMap = [];
    // foreach ($result["floor"] as $floor) {
    //     $index = array_search($floor, $result["floor"]);
    //     if (!array_key_exists($floor, $forMap)) {
    //         $forMap[$floor] = [$result["path"][$index]];
    //     } else {
    //         $forMap[$floor][] = $result["path"][$index];
    //     }
    // }

    // foreach ($result["path"] as $point) {
    //     $index = array_search($point, $result["path"]);
    //     $floor = $result["floor"][$index];
    //     if (!array_key_exists($floor, $forMap)) {
    //         $forMap[$floor] = [$point];
    //     } else {
    //         $forMap[$floor][] = $point;
    //     }
    // }

    // foreach ($forMap as $key => $idList) {
    //     $map = new MapController();
    //     $map = $map->getMap($key, ["mode" => "route", "id" => $idList]);
    //     echo $map . "<br/>";
    // }
    ?>
    <p id="out"></p>
</body>
</html>