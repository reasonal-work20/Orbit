<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . ROUTES . '/carpool-feature.php';

if (isset($_GET["isActive"])) {
    $result = getActive();
    echo json_encode($result);
}

if (isset($_POST["newRide"])) {
    $time = $_POST["time"];
    $time = DateTime::createFromFormat('H:i', $time);
    $formatTime = $time->format('Y-m-d H:i:s');
    $_POST["time"] = $formatTime;
    $result = newRide($_POST);
    if ($result) {
        echo "<script>
        alert('$result');
        </script>";
    } else {
        $path = FEATURES . '/transport/view-ride.php';
        echo "<script>
        window.location.href='$path';
        </script>";
    }
}

if (isset($_GET["host"])) {
    $result = host($_SESSION["userID"]);
    echo json_encode($result);
}

if (isset($_GET["requester"])) {
    $result = requester($_GET["requester"]);
    echo json_encode($result);
}

if (isset($_POST["cancelRide"])) {
    $carpool = host($_SESSION["userID"]);
    $result = cancelRide(["carpoolID" => $carpool["carpoolID"]]);
    if ($result) {
        echo "<script>
        alert('$result');
        </script>";
    } else {
        $path = FEATURES . '/transport/carpool-manage.php';
        echo "<script>
        window.location.href='$path';
        </script>";
    }
}

/**
 * !! IMPORTANT !!
 * Functions Available
 * getAvailable  -> Takes in an associated array and returns the list of available rides.
 *               -> Input Keys [search, role, filter] *Note all three keys must exists (even if empty)
 *               -> Output format [[Refer to output keys for keys], []]
 *               -> Output Keys [carpoolID, name, picture, hostID, time, start, destination, seat]
 * 
 * requester     -> Takes in the carpoolID and returns the details of a carpool ride for the requester pov.
 *               -> Output Keys [carpoolID, name, picture, hostID, time, start, destination, seat, 
 *                              carColour, carPlate, carModel, note, phone, email]
 *
 * host          -> Takes in the carpoolID and returns the details of a carpool ride for the host pov.
 *               -> Output Keys [carpoolID, name, picture, hostID, time, start, destination, seat, 
 *                  carColour, carPlate, carModel, note, requester]
 *               -> Note that requester is a list in the format [[userID, name], [userID, name]]
 * 
 * getActive     -> Output Keys [host, requester, carpoolID] *Note host and requester is True/False indicating their role.
 *
 * newRide       -> Takes in an associated array and returns error string.
 *               -> Input: [userID, type, start, destination, time, carColour, carPlate, carModel, capacity, note]
 *
 * cancelRide    -> Takes in an associated array and returns error string. 
 *               -> Input: [carpoolID]
 *
 * changeStatus  -> Takes in associated array and returns error string.
 *               -> Input: [carpoolID, status]
 *
 * approveRequest -> Takes in associated array and returns error string.
 *                -> Input: [carpoolID, approval]
 *
 * newRequest    -> Takes in associated array and returns error string.
 *               -> Input: [carpoolID, userID]
 *
 * cancelRequest -> Takes in associated array and returns error string.
 *               -> Input: [requestID]
 */
?>