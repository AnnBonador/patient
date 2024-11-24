<?php
include('../admin/config/dbconn.php');
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Profile</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">User Profile</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            include('../admin/message.php');
                            ?>
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#info" data-toggle="tab">Edit Profile</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#pass" data-toggle="tab">Change Password</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="info">
                                            <form action="user-profile-action.php" method="post" enctype="multipart/form-data">
                                                <?php
                                                if (isset($_SESSION['auth'])) {
                                                    $sql = "SELECT * FROM tblpatient WHERE id = '" . $_SESSION['auth_user']['user_id'] . "'";
                                                    $query_run = mysqli_query($conn, $sql);
                                                    while ($row = mysqli_fetch_array($query_run)) {
                                                ?>
                                                        <div class="row">
                                                            <input type="hidden" name="userid" value="<?= $_SESSION['auth_user']['user_id'] ?>">
                                                            <div class="form-group col-md-6">
                                                                <label for="">First Name</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" name="fname" class="form-control" value="<?= $row['fname'] ?>" pattern="[a-zA-Z'-'\s]*" required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Last Name</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" name="lname" class="form-control" value="<?= $row['lname'] ?>" pattern="[a-zA-Z'-'\s]*" required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Address</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" name="address" class="form-control" value="<?= $row['address'] ?>" required>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">Birthdate</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" autocomplete="off" id="datepicker" name="birthday" value="<?= $row['dob'] ?>" class="form-control" required>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label for="">Gender</label>
                                                                <span class="text-danger">*</span>
                                                                <?php $array = array("Female", "Male");
                                                                echo "<select class='custom-select' name='gender' required>";
                                                                foreach ($array as $gender) {
                                                                    if ($gender == $row['gender']) {
                                                                        echo "<option selected>$gender</option>";
                                                                    } else {
                                                                        echo "<option>$gender</option>";
                                                                    }
                                                                }
                                                                echo "</select>";
                                                                ?>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Email</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="email" class="form-control" value="<?= $row['email'] ?>" readonly>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label for="">Contact Number</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control js-phone" value="<?= substr($row['phone'], 3) ?>" name="contact" pattern="^(09|\+639)\d{9}$" required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Patient Image</label>
                                                                <input type="file" name="img_url" placeholder="">
                                                                <input type="hidden" name="old_image" value="<?= $row['image'] ?>" />
                                                                <div id="uploaded_image">
                                                                    <img src="../upload/patients/<?= $row['image'] ?>" class="img-thumbnail img-fluid" width="120" alt="Doctor Image">
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" name="update_user" class="btn btn-danger float-right">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="pass">
                                            <form action="user-profile-action.php" method="post">
                                                <div class="row">
                                                    <input type="hidden" name="userid" value="<?= $_SESSION['auth_user']['user_id'] ?>">
                                                    <div class="form-group col-md-6">
                                                        <label>Current password</label>
                                                        <input type="password" autocomplete="off" name="current_pass" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>New Password</label>
                                                        <input type="password" autocomplete="new-password" name="new_pass" id="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}" title="Must contain at least one number and one uppercase and lowercase letter,at least one special character, and at least 8 or more characters" required>
                                                        <div class="show_hide">
                                                            <small>Password Strength: <span id="result"> </span></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Confirm Password</label>
                                                        <input type="password" autocomplete="new-password" name="confirm_pass" class="form-control" id="confirmPassword" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" name="change_password" class="btn btn-danger float-right">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.tab-pane -->

                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/scripts.php'); ?>
        <script>
            $(document).ready(function() {
                $('#password').keyup(function() {
                    if ($(this).val().length == 0) {
                        $('.show_hide').hide();
                    } else {
                        $('.show_hide').show();
                    }
                }).keyup();

                $('#password').keyup(function() {
                    var password = $('#password').val();
                    if (checkStrength(password) == false) {
                        password.setCustomValidity('');

                    }
                });

                function checkStrength(password) {
                    var strength = 0;

                    //If password contains both lower and uppercase characters, increase strength value.
                    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
                        strength += 1;
                        $('.low-upper-case').addClass('text-success');
                        $('.low-upper-case i').removeClass('fa-exclamation-triangle').addClass('fa-check');
                        $('#popover-password-top').addClass('hide');

                    } else {
                        $('.low-upper-case').removeClass('text-success');
                        $('.low-upper-case i').addClass('fa-exclamation-triangle').removeClass('fa-check');
                        $('#popover-password-top').removeClass('hide');
                    }

                    //If it has numbers and characters, increase strength value.
                    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
                        strength += 1;
                        $('.one-number').addClass('text-success');
                        $('.one-number i').removeClass('fa-exclamation-triangle').addClass('fa-check');
                        $('#popover-password-top').addClass('hide');

                    } else {
                        $('.one-number').removeClass('text-success');
                        $('.one-number i').addClass('fa-exclamation-triangle').removeClass('fa-check');
                        $('#popover-password-top').removeClass('hide');
                    }

                    //If it has one special character, increase strength value.
                    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
                        strength += 1;
                        $('.one-special-char').addClass('text-success');
                        $('.one-special-char i').removeClass('fa-exclamation-triangle').addClass('fa-check');
                        $('#popover-password-top').addClass('hide');

                    } else {
                        $('.one-special-char').removeClass('text-success');
                        $('.one-special-char i').addClass('fa-exclamation-triangle').removeClass('fa-check');
                        $('#popover-password-top').removeClass('hide');
                    }

                    if (password.length > 7) {
                        strength += 1;
                        $('.eight-character').addClass('text-success');
                        $('.eight-character i').removeClass('fa-exclamation-triangle').addClass('fa-check');
                        $('#popover-password-top').addClass('hide');

                    } else {
                        $('.eight-character').removeClass('text-success');
                        $('.eight-character i').addClass('fa-exclamation-triangle').removeClass('fa-check');
                        $('#popover-password-top').removeClass('hide');
                    }

                    // If value is less than 2

                    if (strength < 2) {
                        $('#result').removeClass()
                        $('#password-strength').addClass('bg-danger');

                        $('#result').addClass('text-danger').text('Very Weak');
                        $('#password-strength').css('width', '10%');
                    } else if (strength == 2) {
                        $('#result').addClass('good');
                        $('#password-strength').removeClass('bg-danger');
                        $('#password-strength').addClass('bg-warning');
                        $('#result').addClass('text-warning').text('Weak')
                        $('#password-strength').css('width', '60%');
                        return 'Weak'
                    } else if (strength == 4) {
                        $('#result').removeClass()
                        $('#result').addClass('strong');
                        $('#password-strength').removeClass('bg-warning');
                        $('#password-strength').addClass('bg-success');
                        $('#result').addClass('text-success').text('Very Strong');
                        $('#password-strength').css('width', '100%');

                        return 'Strong'
                    }
                }

                $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                    localStorage.setItem('activeTab', $(e.target).attr('href'));
                });
                var activeTab = localStorage.getItem('activeTab');
                if (activeTab) {
                    $('.nav-pills a[href="' + activeTab + '"]').tab('show');
                }
            });
        </script>
        <?php include('includes/footer.php'); ?>