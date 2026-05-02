<?php
/**
 * Entry point for testing.
*/
require $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.ROUTES.'/campus-navigation.php';

$allData = getLocation(["mode" => "default"]);
$testData = [];

foreach ($allData as $row) {
    $testData[] = $row["locationID"];
}
?>

<html>
<head>
    <title>Campus Navigation Test</title>
</head>

<body>
    <h1>Tests</h1>
    <p id="c"></p>
    <p id="t"></p>
</body>

<script>
    function fac(number) {
        let value = 1;
        for (let i = 1; i <= number; i++) {
            value *= i;
        }
        return value;
    }
    let testData = <?php echo json_encode($testData); ?>;
    let total = fac(testData.length + 2 - 1) / (fac(2) * fac(testData.length - 1));
    let current = 0;
    let success = 0;
    let check = "";
    async function runTests() {
        for (let startIndex = 0; startIndex < testData.length; startIndex++) {
            for (let endIndex = startIndex; endIndex < testData.length; endIndex++) {
                let s = testData[startIndex];
                let e = testData[endIndex];

                let response = await fetch('/Orbit/server/tests/campus-navigation-test.php?start=' + s + '&end=' + e);
                let data = await response.json();

                let result = data.result;
                if (result) {
                    success += 1;
                }
                check += s + "|" + e + "|" + result + "\n";
                current++;
                let percentage = Math.round(current / total * 100);
                document.getElementById("t").innerText = "Running Test " + percentage + "% (" + current + "/" + total + ")\n\nSuccess: " + success + "\n\n" + check;
            }
        }
    }

    runTests();

</script>
</html>