<?php
/**
 * Entry point for testing.
*/
require $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.LOGIC.'/alter-svg.php';
?>

<html>
<head>
    <title>Tests</title>
</head>

<body>
    <h1>Tests</h1>
    <?php
    $test = alterSvg(ROOT.DATA.'/map-l3.svg', ['32', '33', '34'], '#000000');
    echo $test;
    ?>
</body>
</html>