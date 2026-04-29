<?php
/**
* Unit Test for ManageUser Class.
*
* Create    -> Passed, 29/04/2026
* Update    -> Passed, 29/04/2026
* Delete    -> Passed, 29/04/2026
* Read      -> Passed, 29/04/2026
*/

$manageUser = new ManageUser();
echo "Unit Test: User Management<br/>";
echo "Controller: ManageUser (manage-user.php)<br/><br/>";

echo "<strong>Create Test</strong><br/>";
$dataFormat = [
    "name" => "", 
    "password" => "", 
    "email" => "", 
    "phone" => "", 
    "picture" => "", 
    "qualification" => "", 
];

$testData = [
    ["Alice", "alicePassword", "alice@example.com", "+60123456789", "alice.png", null],
    ["Alice", "alicePassword", "alice@example.com", "+60123456789", null, null],
    ["Alice", "alicePassword", "alice@example.com", "+60123456789", "alice.png", "Qualification"],
    ["Alice", "alicePassword", "alice@example.com", "+60123456789", null, "Qualification"]
];
$testDescription = [
    "All Valid Student",
    "Empty Student Picture",
    "All Valid Lecturer",
    "Empty Lecturer Picture"
];
$role = ["Student", "Student", "Lecturer", "Lecturer"];

for ($index = 0; $index < count($testDescription); $index++) {
    $data = $testData[$index];
    $dataFormat["name"] = $data[0];
    $dataFormat["password"] = $data[1];
    $dataFormat["email"] = $data[2];
    $dataFormat["phone"] = $data[3];
    $dataFormat["picture"] = $data[4];
    $dataFormat["qualification"] = $data[5];

    $error = $manageUser->create($dataFormat, $role[$index]);
    $currentTest = $testDescription[$index];
    if (!$error) {
        echo "$currentTest\t: No error.<br/>";
    } else {
        echo "$currentTest\t: $error<br/>";
    }
}

echo "<strong>Update Test</strong><br/>";
$dataFormat = [
    "userID" => 0,
    "name" => "", 
    "password" => "", 
    "email" => "", 
    "phone" => "", 
    "picture" => "", 
    "qualification" => "", 
    "status" => "",
    "studentID" => "",
    "lecturerID" => ""
];

$testData = [
    [4, "Alice", "alicePassword", "alice@example.com", "+60123456789", "aliceNewPic.png", null, "Inactive", "TP000001", null],
    [5, "Jennifer", "jenniferPassword", "jennifer@example.com", "+60123456789", null, null, "Active", "TP000002", null],
    [6, "Luna", "lunaPassword", "luna@example.com", "+60123456789", "luna.png", "Qualification", "Inactive", null, "L000001"],
    [7, "Lia", "liaPassword", "lia@example.com", "+60123456789", null, "Qualification", "Active", null, "L000002"]
];
$testDescription = [
    "All Valid Student",
    "Empty Student Picture",
    "All Valid Lecturer",
    "Empty Lecturer Picture"
];
$role = ["Student", "Student", "Lecturer", "Lecturer"];

for ($index = 0; $index < count($testDescription); $index++) {
    $data = $testData[$index];
    $dataFormat["userID"] = $data[0];
    $dataFormat["name"] = $data[1];
    $dataFormat["password"] = $data[2];
    $dataFormat["email"] = $data[3];
    $dataFormat["phone"] = $data[4];
    $dataFormat["picture"] = $data[5];
    $dataFormat["qualification"] = $data[6];
    $dataFormat["status"] = $data[7];
    $dataFormat["studentID"] = $data[8];
    $dataFormat["lecturerID"] = $data[9];

    $error = $manageUser->update($dataFormat, $role[$index]);
    $currentTest = $testDescription[$index];
    if (!$error) {
        echo "$currentTest\t: No error. $error<br/>";
    } else {
        echo "$currentTest\t: $error<br/>";
    }
}

echo "<strong>Delete Test</strong><br/>";
$dataFormat = [
    "userID" => 0,
];

$testData = [4, 5, 6, 7];
$testDescription = [
    "Delete Alice",
    "Delete Jennifer",
    "Delete Luna",
    "Delete Lia"
];

for ($index = 0; $index < count($testDescription); $index++) {
    $dataFormat["userID"] = $testData[$index];
    $error = $manageUser->delete($dataFormat);
    $currentTest = $testDescription[$index];
    if (!$error) {
        echo "$currentTest\t: No error. $error<br/>";
    } else {
        echo "$currentTest\t: $error<br/>";
    }
}

echo "<strong>Create Test</strong><br/>";
$dataFormat = ["userID" => 0];
$testData = [8, 9, 10, 11];
for ($index = 0; $index < count($testData); $index++) {
    $result = $manageUser->get($testData[$index]);
    echo json_encode($result);
    echo "<br/>";
}
?>