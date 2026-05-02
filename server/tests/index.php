<?php
/**
 * Entry point for testing.
*/
require $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONTROLLERS . '/carpool-controller.php';
require_once ROOT . CONFIG;

$x = new CarpoolController();
// $input = [
//     "userID" => 4,
//     "type" => "Volunteer",
//     "start" => "LRT Bukit Jalil",
//     "destination" => "APU Campus",
//     "time" => "2026-05-02 08:30:00",
//     "carColour" => "White",
//     "carPlate" => "XYZ1234",
//     "carModel" => "Proton",
//     "capacity" => 4,
//     "note" => "Hi, I am going to campus and will pass by LRT Bukit Jalil. Does anyone want to hitch a ride? We’ll just split the petrol price. ~RM1 each."
// ];

$y = $x->getAvailable(["filter" => "", "search" => "", "role" => "Student"]);
echo json_encode($y);
?>

<html>
<head>
    <title>Campus Navigation Test</title>
</head>

<body>
    <h1>Tests</h1>
</body>
</html>