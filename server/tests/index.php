<?php
/**
 * Entry point for testing.
*/
require $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
// require_once ROOT.LOGIC.'/highlight-svg.php';
require_once ROOT.CONTROLLERS.'/map-controller.php';
?>

<html>
<head>
    <title>Tests</title>
</head>

<body>
    <h1>Tests</h1>
    <?php
    $test = new MapController();
    $mode = [
        "mode" => "point",
        "id" => ["Audi6", "337", "336", "339", "32", "31","Audi7"],
    ];
    $result = $test->getMap("3", $mode);
    echo $result;
    ?>
</body>
</html>