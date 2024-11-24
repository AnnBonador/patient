<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
include('payment_config.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
            </div>

            <style>
                .select2-container .select2-selection--single,
                .select2-container--default .select2-selection--single .select2-selection__arrow {
                    height: 100% !important;
                }

                .select2-selection__choice {
                    color: #444 !important;
                    background: transparent !important;
                }
            </style>

            <div class="content">
                <div class="container-fluid">
                    <form action="request_action.php" method="post">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-primary">Set an Appointment</h3>
                                        <hr>
                                        <div class="callout callout-danger">
                                            <p class="h5">Note: After clicking request appointment button it will direct to
                                                <span class="text-primary">Paypal</span>. You can only refund your appointment fee in our clinic. This feature is to protect the site from spammer.
                                            </p>
                                        </div>
                                        <p class="text-justify text-muted">Due to COVID-19 pandemic we are strictly by appointment only until further notice.
                                            Please do not schedule an appointment if you have signs or symptoms of COVID-19.
                                            Wearing a face mask is a must to ensure the safety of Doctors and Patients.We will confirm your appointment via email or call 2 to 3 days before your appointment date.
                                        </p>
                                        <p class="text-justify text-muted">This questionnaire is designed with your safety in mind and must be answered honestly. Your answers will be reviewed prior to your appointment and a member of our team will contact you if we recommend rescheduling to a later date. An answer of YES does not exclude you from treatment. Please answer YES or NO to each of the following questions. Thank you for your consideration and understanding.</p>
                                        <input type="hidden" name="userid" value="<?php echo $_SESSION['auth_user']['user_id']; ?>">
                                        <div class="row col-12">
                                            <div class="form-group col-md-4">
                                                <label>Preferred Dentist</label>
                                                <span class="text-danger">*</span>
                                                <select class="form-control select2 dentist" name="preferredDentist" id="preferredDentist" style="width: 100%;" required>
                                                    <option selected disabled value="">Preferred Doctor</option>
                                                    <?php
                                                    if (isset($_GET['id'])) {
                                                        echo $id = $_GET['id'];
                                                    }
                                                    $sql = "SELECT * FROM tbldoctor WHERE status='1' ORDER BY name ASC";
                                                    $query_run = mysqli_query($conn, $sql);
                                                    if (mysqli_num_rows($query_run) > 0) {
                                                        foreach ($query_run as $row) {
                                                    ?>

                                                            <option value="<?php echo $row['id']; ?>">
                                                                <?php echo $row['name']; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Available Date</label><span class="text-danger">*</span>
                                                <select class="form-control select2" name="preferredDate" id="preferredDate" style="width: 100%;" required>
                                                    <option selected disabled value="">Preferred Date</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Available Time</label><span class="text-danger">*</span>
                                                <select class="form-control select2" name="preferredTime" id="preferredTime" style="width: 100%;" required>
                                                    <option selected disabled value="">Preferred Time</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 form-group">
                                            <label>Service</label><span class="text-danger">*</span>
                                            <select class="select2" multiple="multiple" name="service[]" id="service" data-placeholder="Services" style="width: 100%;" required>
                                                <?php
                                                $sql = "SELECT * FROM procedures ORDER BY procedures ASC";
                                                $query_run = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($query_run) > 0) {
                                                    foreach ($query_run as $row) {
                                                ?>
                                                        <option value="<?php echo $row['procedures']; ?>">
                                                            <?php echo $row['procedures']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        Health Declaration
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $sql = "SELECT * FROM questionnaires";
                                        $query_run = mysqli_query($conn, $sql);
                                        $check_services = mysqli_num_rows($query_run) > 0;

                                        if ($check_services) {
                                            while ($row = mysqli_fetch_array($query_run)) {
                                        ?>
                                                <div class="form-group">
                                                    <label for="" name="qid[<?php echo $row['id'] ?>]"><?= $row['questions'] ?> *</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="ans[<?php echo $row['id'] ?>" value="Yes" required>
                                                        <label class="form-check-label">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="ans[<?php echo $row['id'] ?>" value="No" required>
                                                        <label class="form-check-label" value="No">No</label>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        } else {
                                            echo "<h5> No Record Found</h5>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <button type="submit" class="btn btn-primary" name="insertdata" id="checkBtn">Request Appointment</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <?php include('includes/scripts.php'); ?>
        <script>
            $(document).ready(function() {
                // $('#checkBtn').click(function() {
                //     checked = $("input[type=checkbox]:checked").length;

                //     if(!checked) {
                //         alert("Please, check at least one concern");
                //         return false;
                //     }
                // });
                $('.select2').select2();
                $(".dentist").select2({
                    placeholder: "Select Dentist",
                    allowClear: true
                });
                $("#preferredDate").select2({
                    placeholder: "Available Date",
                    allowClear: true
                });
                $("#service").select2({
                    placeholder: "Services",
                    allowClear: true
                });
                $("#preferredTime").select2({
                    placeholder: "Available Time",
                    allowClear: true
                });
                $("#preferredDentist").on("change", function() {
                    var selectedDentistId = $("#preferredDentist").val();
                    $('#preferredDate').val('');
                    $('#preferredTime').val(null).trigger('change');
                    $('#preferredDate').select2({
                        allowClear: true,
                        placeholder: "Available Date",
                        ajax: {
                            url: 'request_action.php',
                            type: 'GET',
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    doctorIdDate: selectedDentistId,
                                    patientId: <?php echo $_SESSION['auth_user']['user_id']; ?>
                                };
                            },
                            processResults: function(response) {
                                return {
                                    results: response
                                };
                            },
                            cache: true,
                        }
                    }).on('change', function(e) {
                        $("#service").val(null).trigger("change");
                        var data = $(this).select2('data')[0] ?? '';
                        var infoValue = data.info ?? '';
                        console.log(infoValue);

                        var select2Config = {
                            allowClear: true,
                            placeholder: "Select Service"
                        };

                        if (infoValue == 30) {
                            select2Config.minimumResultsForSearch = Infinity;
                            select2Config.maximumSelectionLength = 1;
                        } else if (infoValue == 60) {
                            select2Config.minimumResultsForSearch = Infinity;
                            select2Config.maximumSelectionLength = 2;
                        } else if (infoValue == 120) {
                            select2Config.minimumResultsForSearch = Infinity;
                            select2Config.maximumSelectionLength = 4;
                        } else if (infoValue == 180) {
                            select2Config.minimumResultsForSearch = Infinity;
                            select2Config.maximumSelectionLength = 6;
                        }

                        // Update select2 configuration options for service select box
                        $('#service').select2('destroy').select2(select2Config);
                    });
                });
                $("#preferredDate").on("change", function() {
                    var selectedSchedId = $("#preferredDate").val();
                    $('#preferredTime').val('');
                    $('#preferredTime').select2({
                        allowClear: true,
                        placeholder: "Available Date",
                        ajax: {
                            url: 'request_action.php',
                            type: 'POST',
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    selectedDateId: selectedSchedId,
                                };
                            },
                            processResults: function(response) {
                                return {
                                    results: response
                                };
                            },
                            cache: true,
                        }
                    });
                });
            });
        </script>
        <?php include('includes/footer.php'); ?>