<?php
session_start();
include('includes/header.php');
include('admin/config/dbconn.php');

// Role-based redirection
if (isset($_SESSION['auth'])) {
    $roles = [
        'admin' => 'admin/pages/dashboard',
        'patient' => 'patient/index.php',
        '2' => 'dentist/index.php',
        '3' => 'staff/index.php'
    ];

    if (array_key_exists($_SESSION['auth_role'], $roles)) {
        $_SESSION['status'] = "You are already logged in";
        header("Location: " . $roles[$_SESSION['auth_role']]);
        exit(0);
    }
}
?>

<body class="hold-transition login-page">
    <div class="login-box">
        <?php
        if (isset($_SESSION['auth_status'])) {
            $alertClass = $_SESSION['auth_status_type'] ?? 'warning'; // Default to 'warning' if type isn't set
            echo "<div class='alert alert-{$alertClass} alert-dismissible fade show' role='alert'>
                    {$_SESSION['auth_status']}
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                  </div>";
            unset($_SESSION['auth_status']);
        }
        ?>
        <div class="card card-outline card-primary shadow">
            <div class="card-body login-card-body">
                <a href="index.php">
                    <h3 class="login-box-msg text-danger font-weight-bold"><?php echo $system_name ?></h3>
                </a>
                <p class="login-box-msg">Sign in</p>
                <?php include('admin/message.php'); ?>
                <form action="logincode.php" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" id="password" required />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-eye" id="eye"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="login_btn" class="btn btn-outline-primary btn-block">Log In</button>
                    </div>
                </form>
                <p class="mb-1">
                    <a href="password-reset.php">Forgot password?</a>
                </p>
                <p class="mb-0">
                    <a href="register.php" class="text-center">Create Account</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
<?php include('includes/scripts.php'); ?>
