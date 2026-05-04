<?php
/**
 * Entry point for testing.
*/
require $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONTROLLERS . '/manage-module.php';

$test = new ManageCourse();
$x = $test->createModule([
    "majorID" => "CT",
    "short" => "NWT",
    "name" => "Networking Technologies"
]);
echo $x;
// $x = $test->getMajorList();
// echo json_encode($x);
?>

<html>
<head>
    <title>Campus Navigation Test</title>
</head>

<body>
    <h1>Tests</h1>
    <?php
    ?>
</body>
</html>