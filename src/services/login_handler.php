<?php 

// session_start();

// $doc_root_folder = $_SERVER['DOCUMENT_ROOT'] . '/Orbit';
// include($doc_root_folder . '/src/config/conn.php');
// include_once($doc_root_folder . '/src/config/config.php');

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//     // Retrieve and trim inputs
//     $identifier = trim($_POST['username-or-email']);
//     $password = trim($_POST['password']);

//     // Check if fields are empty
//     if (empty($identifier) || empty($password)) {
//         $_SESSION['login_error'] = "Please fill in all fields.";
//         header("Location: " . BASE_URL . "/src/app/login/login_page.php");
//         exit();
//     }

//     // Prepare the SQL statement
//     $sql = "SELECT * FROM users WHERE name = ? OR email = ?";
//     $stmt = $pdo->prepare($sql);
    
//     if ($stmt === false) {
//         die("Database error during prepare.");
//     }

//     // PDO WAY: Pass the variables directly into execute() as an array
//     $stmt->execute([$identifier, $identifier]);

//     // PDO WAY: Fetch the first matching row directly
//     // (Assuming you set PDO::FETCH_ASSOC in your conn.php as discussed previously)
//     $user = $stmt->fetch(); 

//     // If $user is true, it means a row was found
//     if ($user) {

//         // Verify password
//         if (password_verify($password, $user['password'])) {
            
//             session_regenerate_id(true);
//             $_SESSION['user_id'] = $user['id'];
//             $_SESSION['username'] = $user['name'];
//             $_SESSION['user_role'] = $user['role'];
//             $_SESSION['logged_in'] = true;

//             // Check role
//             switch ($user['role']) {
//                 case 'student':
//                     header("Location: " . BASE_URL . "/src/app/student/#");
//                     break;
//                 case 'lecturer':
//                     header("Location: " . BASE_URL . "/src/app/tutor/#");
//                     break;
//                 case 'admin1':
//                     header("Location: " . BASE_URL . "/src/app/admin/#");
//                     break;
//                 default:
//                     // Fallback if role missing / unrecognized
//                     header("Location: " . BASE_URL . "/src/app/login/login_page.php");
//             }
//             exit();
//         } else {
//             $_SESSION['login_error'] = "Incorrect Password. Please try again.";
//             header("Location: " . BASE_URL . "/src/app/login/login_page.php");
//             exit();
//         }
//     } else {
//         $_SESSION['login_error'] = "No user found with that username or email.";
//         header("Location: " . BASE_URL . "/src/app/login/login_page.php");
//         exit();
//     }
// } else {
//     // Redirect to login page if accessed directly without POST
//     header("Location: " . BASE_URL . "/src/app/login/login_page.php");
//     exit();
// }

?>