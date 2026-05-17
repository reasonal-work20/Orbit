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
        $path = PAGES . '/transport/dashboard.php';
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

if (isset($_GET["cancelRide"])) {
    $carpool = host($_SESSION["userID"]);
    $result = cancelRide(["carpoolID" => $carpool["carpoolID"]]);
    if ($result) {
        echo "<script>
        alert('$result');
        </script>";
    } else {
        $path = PAGES . '/transport/carpool-manage.php';
        echo "<script>
        window.location.href='$path';
        </script>";
    }
}

if (isset($_GET["updateRide"])) {
    $error = changeStatus(["carpoolID" => $_GET['carpoolID'], "status" => $_GET['status']]);
    if ($_GET['status'] === "Completed") {
        echo json_encode(["redirect" => true]);
    }
}

if (isset($_GET['getAvailable'])) {
    $result = getCarpool([
        "search" => $_GET['search'],
        "role" => $_SESSION['role'],
        "filter" => $_GET['filter']
    ]);
    echo json_encode($result);
}

if (isset($_GET['newRequest'])) {
    $error = newRequest([
        "carpoolID" => $_GET['carpoolID'],
        "userID" => $_SESSION['userID']
    ]);
    echo json_encode(["error" => $error]);
}

if (isset($_GET['cancelRequest'])) {
    $error = cancelRequest();
    if (!$error) {
        $path = PAGES . '/transport/dashboard.php';
        echo "<script>window.location.href='$path';</script>";
    }
}

if (isset($_POST['approveRequest'])) {
    $requesterID = $_POST['requesterID'];
    $carpoolID = $_POST['carpoolID'];
    $error = approveRequest([
        "carpoolID" => $carpoolID,
        "requestID" => $requesterID,
        "approval" => "Approved"
    ]);
    if (!$error) {
        $path = PAGES . '/transport/dashboard.php';
        echo "<script>
        window.location.href='$path';
        </script>";
    }
}

if (isset($_POST['rejectRequest'])) {
    $requesterID = $_POST['requesterID'];
    $error = rejectRequest($requesterID);
    if (!$error) {
        $path = PAGES . '/transport/dashboard.php';
        echo "<script>
        window.location.href='$path';
        </script>";
    }
}

/**
 * !! IMPORTANT !!
 * Functions Available
 * getCarpool  -> Takes in an associated array and returns the list of available rides.
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