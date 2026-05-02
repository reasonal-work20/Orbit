<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . ROUTES . '/campus-navigation.php';

$file = fopen(ROOT . TESTS . '/temp.txt', 'r');
if ($file) {
    $line = fgets($file);
    $cleanLine = trim($line);
    $index = explode(",", $cleanLine);
    $startIndex = (int)$index[0];
    $endIndex = (int)$index[1];

    $mode = ["mode" => "default"];
    $locationList = getLocation($mode);
    $testData = [];
    foreach ($locationList as $row) {
        $testData[] = $row["locationID"];
    }

    if ($endIndex > count($testData)) {
        $startIndex += 1;
        $endIndex = $startIndex;
    }
    if ($startIndex > count($testData)) {
        exit;   
    }

    $result = getMap([
        "mode" => "route",
        "start" => $testData[$startIndex], 
        "end" => $testData[$endIndex], 
        "type" => "stair"
    ]);
    $endIndex += 1;
    $text = $startIndex . "," . $endIndex;
    file_put_contents(ROOT . TESTS . '/temp.txt', $text);
    header('Content-Type: application/json');
    echo json_encode(["path" => [$testData[$startIndex], $testData[$endIndex-1]], "svg" => $result["svg"]]);
} else {
    header('Content-Type: application/json');
    echo json_encode(["path" => "Can't open file.", "svg" => []]);
}
?>