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
    if ($error) {
        $_SESSION['error'] = $error;
    }
    $path = PAGES . '/transport/dashboard.php';
    echo "<script>
    window.location.href='$path';
    </script>";
}

if (isset($_POST['rejectRequest'])) {
    $requesterID = $_POST['requesterID'];
    $error = rejectRequest($requesterID);
    if ($error) {
        $_SESSION['error'] = $error;
    }
    $path = PAGES . '/transport/dashboard.php';
    echo "<script>
    window.location.href='$path';
    </script>";
}
?>