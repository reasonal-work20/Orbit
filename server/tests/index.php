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