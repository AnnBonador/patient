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
                    <form action="request_action.php" id="create-appointment" method="post">
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
                                        <p class="text-justify text-muted">This questionnaire is designed with your safety in mind and must be answered honestly. Your answers will be reviewed prior to your appointment and a member of our team will contact you if we recommend rescheduling to a later date. An answer of YES does not exclude you from treatment. Please answer YES or NO to each of the following questions. Thank you for your consideration and understanding.</p>
                                        <input type="hidden" name="userid" value="<?php echo $_SESSION['auth_user']['user_id']; ?>">
                                        <div class="row col-12">
                                            <div class="form-group col-md-4">
                                                <label>Preferred Dentist</label>
                                                <span class="text-danger">*</span>
                                                <select class="form-control dentist" name="preferredDentist" id="preferredDentist" style="width: 100%;" required>
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
                                                <input type="text" id="scheddate" name="scheddate" class="form-control" autocomplete="off" readonly>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div id="time-slots" class="row">
                                                    <!-- Dynamic time slots will appear here -->
                                                </div>
                                                <input type="hidden" id="selected-time-slot" name="selected_time_slot">
                                            </div>
                                        </div>

                                        <div class="col-12 form-group">
                                            <label>Service</label><span class="text-danger">*</span>
                                            <select class="form-control" multiple="multiple" name="service[]" id="service" data-placeholder="Services" style="width: 100%;" required>
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
                initializeSelect2(".dentist", "Select Dentist");
                initializeSelect2("#service", "Select Service");
                initializeCalendarDate("#scheddate");

                handleTimeSlotClick(".time-slot", "#selected-time-slot", "slot");

                validateFormSubmission("#create-appointment", "#selected-time-slot");

                $("#preferredDentist").change(function() {
                    const selectedDoctorId = $(this).val();

                    $("#scheddate").val("");
                    $("#time-slots").empty();
                    $("#scheddate").off("changeDate");
                    $("#scheddate").datepicker("destroy").datepicker({
                        autoclose: true,
                        startDate: new Date(),
                    });

                    if (selectedDoctorId) {
                        $.ajax({
                            url: "request_action.php",
                            type: "GET",
                            data: {
                                dentist: true,
                                doctor_id: selectedDoctorId,
                            },
                            dataType: "json",
                            success: function(doctor) {
                                // Check if there is an error in the response
                                if (doctor.error) {
                                    // Display a custom error message
                                    const errorMessage =
                                        "Sorry, the schedule for the selected doctor is not available. Please choose another doctor or try again later.";
                                    $("#time-slots").html(`<div class="col-12 text-danger">${errorMessage}</div>`);
                                    return; // Exit the function to prevent further execution
                                }

                                const availableDays = doctor.available_days;
                                const disabledDays = [0, 1, 2, 3, 4, 5, 6].filter(
                                    (day) => !availableDays.includes(["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"][day])
                                );

                                $("#scheddate").datepicker("setDaysOfWeekDisabled", disabledDays);

                                $("#scheddate").on("changeDate", function(e) {
                                    const selectedDate = e.format();

                                    $.ajax({
                                        url: "request_action.php",
                                        type: "GET",
                                        data: {
                                            timeslots: true,
                                            doctor_id: selectedDoctorId,
                                            date: selectedDate,
                                        },
                                        dataType: "json",
                                        success: function(response) {
                                            // Check if available_time_slots is an empty array
                                            if (response.available_time_slots && response.available_time_slots.length > 0) {
                                                let slotsHtml = '<div class="col-12"><h5>Available Time Slots:</h5></div>';
                                                response.available_time_slots.forEach((slot) => {
                                                    slotsHtml += ` <button type="button" class="col-md-2 btn btn-outline-primary time-slot" data-slot="${slot}">${slot}</button>`;
                                                });
                                                $("#time-slots").html(slotsHtml);
                                            } else {
                                                // Display the custom message for no available time slots
                                                const noSlotsMessage =
                                                    "Sorry, the time slot for the selected doctor is not available. Please choose another doctor or try again later.";
                                                $("#time-slots").html(`<div class="col-12 text-danger">${noSlotsMessage}</div>`);
                                            }
                                        },
                                        error: function(error) {
                                            console.log("Error fetching time slots:", error);
                                        },
                                    });
                                });
                            },
                            error: function(error) {
                                console.log("Error fetching doctor schedule:", error);
                            },
                        });
                    }
                });
            });
        </script>
        <?php include('includes/footer.php'); ?>