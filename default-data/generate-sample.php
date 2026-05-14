<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . ROUTES . '/user-management-route.php';

if (file_exists('C:\\Users\\User\\Downloads\\sample profile\\Student (2).png')) {
    echo "File exists";
} else {
    echo "Can't find file";
}

$male = [
    'name' => 'Student (2).png',
    'type' => 'image/png',
    'tmp_name' => 'C:\\Users\\User\\Downloads\\sample profile\\Student (2).png',
    'error' => 0,
    'size' => filesize("C:\\Users\\User\\Downloads\\sample profile\\Student (2).png")
];
$female = [
    'name' => 'Student (1).png',
    'type' => 'image/png',
    'tmp_name' => 'C:\\Users\\User\\Downloads\\sample profile\\Student (1).png',
    'error' => 0,
    'size' => filesize("C:\\Users\\User\\Downloads\\sample profile\\Student (1).png")
];

$file = fopen(ROOT . '/Orbit/default-data/user.txt', 'r');
if ($file) {
    $firstName = fgets($file);
    $lastName = fgets($file);
    $maleList = fgets($file);
    $femaleList = fgets($file);

    $firstName = trim($firstName);
    $lastName = trim($lastName);
    $maleList = trim($maleList);
    $femaleList = trim($femaleList);

    $firstName = explode(",", $firstName);
    $lastName = explode(",", $lastName);
    $maleList = explode(",", $maleList);
    $femaleList = explode(",", $femaleList);

    $count = 11;
    foreach ($firstName as $name1) {
        foreach ($lastName as $name2) {
            $name = $name1 . " " . $name2;
            $password = "Tp" . str_pad($count, 6, "0", STR_PAD_LEFT) . "@0101";
            $email = "TP" .str_pad($count, 6, "0", STR_PAD_LEFT) . "@mail.apu.edu.my";
            $phone = "+6012-5599623";
            $role = "Student";

            $input = [
                "name" => $name,
                "password" => $password,
                "email" => $email,
                "phone" => $phone,
                "role" => $role
            ];

            if (in_array($name1, $maleList)) {
                $_FILES['picture'] = $male;
            } else {
                $_FILES['picture'] = $female;
            }
            $error = createUser($input, $_FILES);
            echo $error;
            $count += 1;
        }
    }
}
?>