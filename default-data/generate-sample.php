<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . CONFIG;
// require_once ROOT . CONTROLLERS . '/manage-intake.php';
// require_once ROOT . MODELS . '/intake.php';
// require_once ROOT . CONTROLLERS . '/manage-module.php';

// $file = fopen(ROOT . '/Orbit/default-data/capacity.txt', 'r');
// if ($file) {
//     while ($row = fgets($file)) {
//         $data = explode(",", $row);
//         $locationID = $data[0];
//         $capacity = (int)$data[1];
//         $sql = "INSERT INTO classroom (location_id, capacity) VALUES ('$locationID', $capacity);";
//         mysqli_query($connect, $sql);
//     }
// }

// $manageIntake = new ManageIntake();
// $intakeEditor = new Intake($connect);

// $manageModule = new ManageCourse();

// $file = fopen(ROOT . '/Orbit/default-data/Module.txt', 'r');
// if ($file) {
//     while ($row = fgets($file)) {
//         $split = explode(",", $row);
//         $manageModule->createModule([
//             "majorID" => $split[0],
//             "name" => $split[1],
//             "short" => $split[2]
//         ]);
//     }
// }


// $count = 1;
// $file = fopen(ROOT . '/Orbit/default-data/Diploma.txt', 'r');
// if ($file) {
//     while ($row = fgets($file)) {
//         $splitRow = explode(",", $row);
//         $intakeID = $intakeEditor->createIntake($splitRow[0], $splitRow[1], $splitRow[2], $splitRow[3], $splitRow[4]);
//         echo json_encode($intakeID['id']);
//         $total = (int)$splitRow[5];
//         for ($x = 1; $x < $total; $x++) {
//             $manageIntake->addStudent(["intakeID" => $intakeID['id'], "studentID" => "TP" . str_pad($count, 6, "0", STR_PAD_LEFT)]);
//             $count += 1;
//         }
//     }
// }

// if (file_exists('C:\\Users\\User\\Downloads\\sample profile\\Student (2).png')) {
//     echo "File exists";
// } else {
//     echo "Can't find file";
// }

// $male = [
//     'name' => 'Student (2).png',
//     'type' => 'image/png',
//     'tmp_name' => 'C:\\Users\\User\\Downloads\\sample profile\\Student (2).png',
//     'error' => 0,
//     'size' => filesize("C:\\Users\\User\\Downloads\\sample profile\\Student (2).png")
// ];
// $female = [
//     'name' => 'Student (1).png',
//     'type' => 'image/png',
//     'tmp_name' => 'C:\\Users\\User\\Downloads\\sample profile\\Student (1).png',
//     'error' => 0,
//     'size' => filesize("C:\\Users\\User\\Downloads\\sample profile\\Student (1).png")
// ];

// $file = fopen(ROOT . '/Orbit/default-data/temp.txt', 'r');
// if ($file) {
//     $firstName = fgets($file);
//     $lastName = fgets($file);
//     $maleList = fgets($file);
//     $femaleList = fgets($file);

//     $firstName = trim($firstName);
//     $lastName = trim($lastName);
//     $maleList = trim($maleList);
//     $femaleList = trim($femaleList);

//     $firstName = explode(",", $firstName);
//     $lastName = explode(",", $lastName);
//     $maleList = explode(",", $maleList);
//     $femaleList = explode(",", $femaleList);

//     $count = 1;
//     $q = 0;
//     $qualification = [
//         "Doctor of  Philosophy in Information System",
//         "Doctor of Philosophy in Data Science",
//         "Master in Information Technology",
//         "Master of Business Administration",
//         "Master of Entrepreneurship"
//     ];
//     foreach ($firstName as $name1) {
//         foreach ($lastName as $name2) {
//             $name = $name1 . " " . $name2;
//             $password = "L" . str_pad($count, 6, "0", STR_PAD_LEFT) . "@0101";
//             $email = "L" .str_pad($count, 6, "0", STR_PAD_LEFT) . "@mail.apu.edu.my";
//             $phone = "+6012-5599623";
//             $role = "Lecturer";

//             $input = [
//                 "name" => $name,
//                 "password" => $password,
//                 "email" => $email,
//                 "phone" => $phone,
//                 "role" => $role,
//                 "qualification" => $qualification[$q]
//             ];

//             if (in_array($name1, $maleList)) {
//                 $_FILES['picture'] = $male;
//             } else {
//                 $_FILES['picture'] = $female;
//             }
//             $error = createUser($input, $_FILES);
//             echo $error;
//             $count += 1;
//             $q += 1;
//             if ($q == count($qualification)) {
//                 $q = 0;
//             }
//         }
//     }
// }
?>