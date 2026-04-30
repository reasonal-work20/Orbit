<?php
/**
 * Entry point for testing.
*/
require $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
include ROOT.CONFIG;
require_once ROOT.CONTROLLERS.'/dijkstra.php';
// require_once ROOT.ROUTES.'/user-management-route.php';

if (isset($_POST["file"])) {
    echo "Run<br/>";
    print_r($_FILES);
    echo deleteUser($_POST, $_FILES);
}
?>

<html>
<head>
    <title>Tests</title>
</head>

<body>
    <h1>Tests</h1>
    <p><?php
    $x = '{
        "A": [["B", "F", "D"], [2, 3, 5]],
        "B": [["E", "A", "F", "C"], [1, 2, 4, 7]],
        "C": [["E", "G", "B"], [3, 4, 7]],
        "D": [["G", "E", "A"], [1, 1, 5]],
        "E": [["B", "D", "G", "C"], [1, 1, 3, 3]],
        "F": [["A", "B"], [3, 4]],
        "G": [["D", "E", "C"], [1, 3, 4]],
        "H": [["I"], [5]],
        "I": [["H"], [5]]
    }';

    $y = json_decode($x, true);
    $start = ["A", "B", "C", "D", "E", "F", "G", "H", "I"];
    $end = ["A", "B", "C", "D", "E", "F", "G", "H", "I"];
    foreach ($start as $s) {
        foreach ($end as $e) {
            echo json_encode(dijkstra($s, $e, $y)) . "<br/>";
        }
    }
    ?></p>
    <!-- <form method="post" enctype="multipart/form-data">
        <input type="file" name="file" required/>
        <input type="hidden" name="userID" value="13" /> 
        <input type="hidden" name="name" value="Jane" />
        <input type="hidden" name="password" value="janePassword" />
        <input type="hidden" name="email" value="jane@example.com" />
        <input type="hidden" name="phone" value="+6012454632" />
        <input type="hidden" name="role" value="Student" />
        <input type="hidden" name="status" value="Active" />
        <input type="hidden" name="qualification" value="Q" />
        <input type="submit" name="file"/>
    </form> -->
</body>
</html>