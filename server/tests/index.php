<?php
/**
 * Entry point for testing.
*/
require $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.CONTROLLERS.'/navigate-controller.php';
require_once ROOT.CONTROLLERS.'/map-controller.php';
require_once ROOT.LOGIC.'/same-floor-navigate.php';
require_once ROOT.ROUTES.'/campus-navigation.php';
?>

<html>
<head>
    <title>Campus Navigation Test</title>
</head>

<body>
    <h1>Tests</h1>
    <p id="t">
    <?php
    // $mode = [
    //     "mode" => "route",
    //     "start" => "A0401",
    //     "end" => "Audi5",
    //     "type" => "stair"
    // ];
    // $test = getMap($mode);
    // echo $test["svg"][0];
    ?>
    </p>
    <div id="1">
        <h3 id="p1"></h3>
        <div id="svg1"></div>
    </div>
    <div id="2">
        <h3 id="p2"></h3>
        <div id="svg2"></div>
    </div>
    <div id="3">
        <h3 id="p3"></h3>
        <div id="svg3"></div>
    </div>
    <div id="4">
        <h3 id="p4"></h3>
        <div id="svg4"></div>
    </div>
    <div id="5">
        <h3 id="p5"></h3>
        <div id="svg5"></div>
    </div>
</body>

<script>
    let parts = [
        ["p1", "svg1"],
        ["p2", "svg2"],
        ["p3", "svg3"],
        ["p4", "svg4"],
        ["p5", "svg5"]
    ];

    for (let row of parts) {
        fetch ('/Orbit/server/tests/campus-navigation-test.php')
        .then(response => response.json())
        .then(data => {
            let path = data.path;
            document.getElementById(row[0]).innerHTML = path.join(" -> ");
            let svgList = data.svg;
            for (let svg of svgList) {
                document.getElementById(row[1]).innerHTML += svg + "\n";
            }
        })
    }

    document.addEventListener("keydown", function(event) {
        window.location.reload();
    });
</script>
</html>