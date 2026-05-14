<?php
/**
 * Entry point for testing.
*/
require $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
?>

<html>
<head>
    <title>Test</title>
</head>

<body>
    <h1>Tests</h1>
    <h3>Location Highlighted:</h3>
    <p id="count"></p>
    <button onclick="test()">Next</button>
    <p id="detail"></p>
    <div id="map"></div>
</body>

<script>
let count = 0;
let locationList = [];

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

async function get() {
  const response = await fetch('/Orbit/client/src/services/campus-navigation-service.php?floor=&type=&getLocation=%23');
  const result = await response.json();
  locationList = result.result;

  // start looping automatically
  while (count < locationList.length) {
    let row = locationList[count];
    document.getElementById("detail").innerHTML = row.name;

    const response2 = await fetch(`/Orbit/client/src/services/campus-navigation-service.php?mode=point&point=${row.locationID}&getMap=%23`);
    const result2 = await response2.json();
    document.getElementById("map").innerHTML = result2.svg[0];

    count++;
    document.getElementById("count").innerHTML = count;

    await sleep(500); // wait 0.5 seconds before next
  }
}

get();
</script>
</html>