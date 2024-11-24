<?php
session_start();
include('admin/config/dbconn.php');

if (isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Query to fetch user by email
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $user_id = $row['id'];
        $user_fname = $row['name'];
        $user_email = $row['email'];
        $role_as = $row['role'];
        $user_status = $row['status'];

        // Verify the password
        if (password_verify($password, $row['password'])) {
            if ($user_status == '1') {
                // Successful login
                $_SESSION['auth'] = true;
                $_SESSION['auth_role'] = $role_as;
                $_SESSION['auth_user'] = [
                    'user_id' => $user_id,
                    'user_fname' => $user_fname,
                    'user_email' => $user_email
                ];

                // Redirect based on role
                switch ($role_as) {
                    case 'admin':
                        header('Location: admin/pages/dashboard');
                        break;
                    case '3':
                        header('Location: staff/index.php');
                        break;
                    case '2':
                        header('Location: dentist/index.php');
                        break;
                    case 'patient':
                        header('Location: patient/index.php');
                        break;
                    default:
                        $_SESSION['danger'] = "Access Denied";
                        header('Location: login.php');
                }
                exit();
            } elseif ($user_status == '4') {
                // Account not confirmed
                $_SESSION['danger'] = "You have not confirmed your account yet. Please check your inbox and verify your email.";
            } else {
                // Account disabled
                $_SESSION['danger'] = "Your account is temporarily disabled. Please contact the admin.";
            }
        } else {
            // Incorrect password
            $_SESSION['error'] = "Incorrect Email or Password.";
        }
    } else {
        // No user found
        $_SESSION['error'] = "No account found with this email.";
    }
    header('Location: login.php');
    exit();
} else {
    // Unauthorized access to this file
    $_SESSION['error'] = "Access Denied.";
    header('Location: patients.php');
    exit();
}
?>
