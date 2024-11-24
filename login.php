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
            <h3 class="login-box-msg text-danger font-weight-bold">System Name</h3>
            <p class="login-box-msg">Sign in</p>
            <?php include('admin/message.php'); ?>
            <div id="alert-message" class="alert alert-danger d-none" role="alert"></div>
            <form id="login-form">
                <div class="input-group mb-3">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="email-error"></div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="password-error"></div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-primary btn-block">Log In</button>
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
</body>

</html>
<?php include('includes/scripts.php'); ?>
<script>
    $(document).ready(function () {
        $('#login-form').on('submit', function (e) {
            e.preventDefault(); 

            $('.invalid-feedback').text('');
            $('.form-control').removeClass('is-invalid');
            $('#alert-message').addClass('d-none').text('');

            const formData = {
                email: $('#email').val(),
                password: $('#password').val()
            };

            $.ajax({
                url: 'logincode.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        window.location.href = response.redirect;
                    } else {
                        if (response.message) {
                            $('#alert-message').removeClass('d-none').text(response.message);
                        }

                        if (response.errors) {
                            if (response.errors.email) {
                                $('#email-error').text(response.errors.email);
                                $('#email').addClass('is-invalid');
                            }
                            if (response.errors.password) {
                                $('#password-error').text(response.errors.password);
                                $('#password').addClass('is-invalid');
                            }
                        }
                    }
                }
            });
        });
    });
</script>