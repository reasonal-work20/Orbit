<?php 

session_start();

$doc_root_folder = $_SERVER['DOCUMENT_ROOT'] . '/Orbit';
include($doc_root_folder . '/src/config/conn.php');
include_once($doc_root_folder . '/src/config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve and trim inputs
    $identifier = trim($_POST['username-or-email']);
    $password = trim($_POST['password']);

    

    // Check if fields are empty
    if (empty($identifier) || empty($password)) {
        $_SESSION['login_error'] = "Please fill in all fields.";
        header("Location: " . BASE_URL . "/src/app/login/login_page.php");
        exit();
    }

    // Prepare the SQL statement
    $sql = "SELECT * FROM users WHERE name = ? OR email = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Database error during prepare " . $conn->error);
    }

    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();

    // Fetch result
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['logged_in'] = true;

            // Check role
            switch ($user['role']) {
                case 'student':
                    header("Location: " . BASE_URL . "/src/app/student/dashboard.php");
                    break;
                case 'lecturer':
                    header("Location: " . BASE_URL . "/src/app/tutor/dashboard.php");
                    break;
                case 'admin1':
                    header("Location: " .BASE_URL . "/src/app/admin/#");
                    break;
                default:
                    // Fallback if role missing / unrecognized
                    header("Location: " . BASE_URL . "/src/app/login/login_page.php");
            }
            exit();
        } else {
            $_SESSION['login_error'] = "Incorrect Password. Please try again.";
            header("Location: " . BASE_URL . "/src/app/login/login_page.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "No user found with that username or email.";
        header("Location: " . BASE_URL . "/src/app/login/login_page.php");
        exit();
    }
} else {
    // Redirect to login page if accessed directly without POST
    header("Location: " . BASE_URL . "/src/app/login/login_page.php");
    exit();
}

?>