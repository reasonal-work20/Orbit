<?php
/**
 * Entry point for testing.
*/
require $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . MODELS . '/bus.php';
?>

<html>
<head>
    <title>Campus Navigation Test</title>
</head>

<body>
    <h1>Tests</h1>
    <?php
    $x = new Bus();
    $y = $x->getFew("M VERTICA >> APU", 5);
    foreach ($y as $row) {
        echo $row[0] . " >> " . $row[1] . "<br/>";
        echo json_encode($row[2]);
        echo "<br/>";
    }
    ?>
</body>
</html>