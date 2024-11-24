<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="modal fade" id="AddDentalModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Dental History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        $user = "SELECT * FROM tblpatient WHERE id='$user_id'";
                        $users_run = mysqli_query($conn, $user);

                        if (mysqli_num_rows($users_run) > 0) {
                            foreach ($users_run as $user) {
                    ?>
                                <form action="medical_action.php" method="POST">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Previous Dentist</label>
                                                    <input type="hidden" name="patient" value="<?= $user['id'] ?>">
                                                    <input type="text" name="dentist" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Last Dental Visit</label>
                                                    <input type="text" name="visit" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" name="dental_record" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="EditDentalModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Dental History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="medical_action.php" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" name="edit_id" id="edit_id">
                                    <input type="hidden" name="userid" id="patient_id">
                                    <div class="form-group">
                                        <label for="">Previous Dentist</label>
                                        <input type="text" id="edit_dentist" name="dentist" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Last Dental Visit</label>
                                        <input type="text" id="edit_visit" name="visit" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="update_dental" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="AddMedicalModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Medical History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        $user = "SELECT * FROM tblpatient WHERE id='$user_id'";
                        $users_run = mysqli_query($conn, $user);

                        if (mysqli_num_rows($users_run) > 0) {
                            foreach ($users_run as $user) {
                    ?>
                                <form action="medical_action.php" method="POST">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <input type="hidden" name="patient" value="<?= $user['id'] ?>">
                                                <label for="">Are you in good health?</label>
                                                <input type="text" name="q1" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Are you under medical treatment now? If so, what is the condition being treated?</label>
                                                <input type="text" name="q2" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Have you ever had serious illness or surgical operation? If so, what illness or operation</label>
                                                <input type="text" name="q3" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Have you ever been hospitalized? If so, when and why?</label>
                                                <input type="text" name="q4" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Are you taking any prescription/non-prescription medication? If so, please specify</label>
                                                <input type="text" name="q5" class="form-control" required>
                                            </div>
                                        </div>
                                        <label for="">Do patient have allergy to any of the following? If so, please specify (Latex, Penicilin Antibiotics, Aspirin, Sulfa Drugs, Local Anesthetic)</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" name="allergy" class="form-control" required>
                                            </div>
                                        </div>
                                        <label for="">Do patient had any of the following?</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="High Blood Pressure" <?php echo isset($row['med']) && in_array("High Blood Pressure", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">High Blood Pressure</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Low Blood Pressure" <?php echo isset($row['med']) && in_array("Low Blood Pressure", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Low Blood Pressure</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Epilepsy" <?php echo isset($row['med']) && in_array("Epilepsy", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Epilepsy</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="AIDS or HIV Infection" <?php echo isset($row['med']) && in_array("AIDS or HIV Infection", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">AIDS or HIV Infection</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Fainting Seizure" <?php echo isset($row['med']) && in_array("Fainting Seizure", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Fainting Seizure</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Rapid Weight Loss" <?php echo isset($row['med']) && in_array("Rapid Weight Loss", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Rapid Weight Loss</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Asthma" <?php echo isset($row['med']) && in_array("Asthma", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Asthma</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Cancer/Tumors" <?php echo isset($row['med']) && in_array("Cancer/Tumors", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Cancer/Tumors</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="None" <?php echo isset($row['med']) && in_array("None", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">None</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Heart Attack" <?php echo isset($row['med']) && in_array("Heart Attack", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Heart Attack</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Heart Attack" <?php echo isset($row['med']) && in_array("Heart Attack", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Heart Disease</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Hepatitis" <?php echo isset($row['med']) && in_array("Hepatitis", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Hepatitis</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Tuberculosis" <?php echo isset($row['med']) && in_array("Tuberculosis", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Tuberulosis</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Kidney Disease" <?php echo isset($row['med']) && in_array("Kidney Disease", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Kidney Disease</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Kidney Disease" <?php echo isset($row['med']) && in_array("Diabetes", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Diabetes</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Stroke" <?php echo isset($row['med']) && in_array("Stroke", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Stroke</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Anemia" <?php echo isset($row['med']) && in_array("Anemia", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Anemia</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Emphysema" <?php echo isset($row['med']) && in_array("Emphysema", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Emphysema</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" id="checkBtn" name="medical_record" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="EditMedicalModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Medical History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        $user = "SELECT * FROM medical_record WHERE patient_id='$user_id'";
                        $users_run = mysqli_query($conn, $user);

                        if (mysqli_num_rows($users_run) > 0) {
                            foreach ($users_run as $row) {
                    ?>
                                <form action="medical_action.php" method="POST">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <input type="hidden" name="patient" value="<?= $row['patient_id'] ?>">
                                                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                                <label for="">Are you in good health?</label>
                                                <input type="text" name="q1" value="<?= $row['q1'] ?>" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Are you under medical treatment now? If so, what is the condition being treated?</label>
                                                <input type="text" name="q2" value="<?= $row['q2'] ?>" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Have you ever had serious illness or surgical operation? If so, what illness or operation</label>
                                                <input type="text" name="q3" value="<?= $row['q3'] ?>" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Have you ever been hospitalized? If so, when and why?</label>
                                                <input type="text" name="q4" value="<?= $row['q4'] ?>" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Are you taking any prescription/non-prescription medication? I so, please specify</label>
                                                <input type="text" name="q5" value="<?= $row['q5'] ?>" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Do patient have allergy to any of the following? If so, please specify (Latex, Penicilin Antibiotics, Aspirin, Sulfa Drugs, Local Anesthetic)</label>
                                                <input type="text" class="form-control" name="allergy" value="<?= $row['allergy'] ?>" required>
                                            </div>
                                        </div>
                                        <label for="">Do patient have allergy to any of the following?</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="High Blood Pressure" <?php echo isset($row['med']) && in_array("High Blood Pressure", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">High Blood Pressure</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Low Blood Pressure" <?php echo isset($row['med']) && in_array("Low Blood Pressure", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Low Blood Pressure</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Epilepsy" <?php echo isset($row['med']) && in_array("Epilepsy", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Epilepsy</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input " name="med[]" type="checkbox" value="AIDS or HIV Infection" <?php echo isset($row['med']) && in_array("AIDS or HIV Infection", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">AIDS or HIV Infection</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Fainting Seizure" <?php echo isset($row['med']) && in_array("Fainting Seizure", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Fainting Seizure</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input " name="med[]" type="checkbox" value="Rapid Weight Loss" <?php echo isset($row['med']) && in_array("Rapid Weight Loss", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Rapid Weight Loss</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Asthma" <?php echo isset($row['med']) && in_array("Asthma", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Asthma</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Cancer/Tumors" <?php echo isset($row['med']) && in_array("Cancer/Tumors", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Cancer/Tumors</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="None" <?php echo isset($row['med']) && in_array("None", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">None</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Heart Attack" <?php echo isset($row['med']) && in_array("Heart Attack", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Heart Attack</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Heart Attack" <?php echo isset($row['med']) && in_array("Heart Attack", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Heart Disease</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Hepatitis" <?php echo isset($row['med']) && in_array("Hepatitis", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Hepatitis</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Tuberculosis" <?php echo isset($row['med']) && in_array("Tuberculosis", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Tuberulosis</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Kidney Disease" <?php echo isset($row['med']) && in_array("Kidney Disease", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Kidney Disease</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Kidney Disease" <?php echo isset($row['med']) && in_array("Diabetes", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Diabetes</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input " name="med[]" type="checkbox" value="Stroke" <?php echo isset($row['med']) && in_array("Stroke", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Stroke</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Anemia" <?php echo isset($row['med']) && in_array("Anemia", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Anemia</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Emphysema" <?php echo isset($row['med']) && in_array("Emphysema", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Emphysema</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" id="checkBtn2" name="update_medical_record" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>


        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            include('message.php');
                            ?>
                            <div class="card card-primary card-outline card-tabs">
                                <div class="card-header p-0 pt-1 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="overview-tab" data-toggle="tab" data-target="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="history-tab" data-toggle="tab" data-target="#history" role="tab" aria-controls="history" aria-selected="false">Medical History</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="treatment-tab" data-toggle="tab" data-target="#treatment" role="tab" aria-controls="treatment" aria-selected="false">Treatments</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="card card-primary card-outline">
                                                        <?php
                                                        if (isset($_GET['id'])) {
                                                            $user_id = $_GET['id'];
                                                            $user = "SELECT * FROM tblpatient WHERE id='$user_id'";
                                                            $users_run = mysqli_query($conn, $user);

                                                            if (mysqli_num_rows($users_run) > 0) {
                                                                foreach ($users_run as $user) {
                                                        ?>
                                                                    <div class="card-body box-profile">
                                                                        <div class="text-center">
                                                                            <img class="profile-user-img img-fluid img-circle" src="../upload/patients/<?= $user['image'] ?>" alt="User profile picture">
                                                                        </div>
                                                                        <h4 class="profile-username text-center"><?= $user['fname'] . ' ' . $user['lname'] ?></h4>
                                                                        <p class="text-muted text-center"><?= $user['email'] ?></p>
                                                                        <ul class="list-group list-group-unbordered mb-3">
                                                                            <li class="list-group-item">
                                                                                <b>Gender</b>
                                                                                <p class="float-right text-muted m-0"><?= $user['gender'] ?></p>
                                                                            </li>
                                                                            <li class="list-group-item">
                                                                                <b>Birthdate</b>
                                                                                <p class="float-right text-muted m-0"><?= $user['dob'] ?></p>
                                                                            </li>
                                                                            <li class="list-group-item">
                                                                                <b>Phone</b>
                                                                                <p class="float-right text-muted m-0"><?= $user['phone'] ?></p>
                                                                            </li>
                                                                            <li class="list-group-item">
                                                                                <b>Address</b>
                                                                                <p class="float-right text-muted m-0"><?= $user['address'] ?></p>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>

                                                <div class="col-md-9">
                                                    <div class="card">
                                                        <div class="card-header p-2">
                                                            <ul class="nav nav-pills" id="custom-tabs-three-tab" role="tablist">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="appointment-tab" data-toggle="tab" data-target="#appointment" role="tab" aria-controls="appointment" aria-selected="true">Appointment</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="payment-tab" data-toggle="tab" data-target="#payment" role="tab" aria-controls="payment" aria-selected="false">Payment</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="prescription-tab" data-toggle="tab" data-target="#prescription" role="tab" aria-controls="prescription" aria-selected="false">Prescription</a>
                                                                </li>
                                                            </ul>
                                                        </div>


                                                        <div class="card-body">
                                                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                                                <div class="tab-pane fade show active" id="appointment" role="tabpanel" aria-labelledby="appointment-tab">
                                                                    <!-- Appointment-->
                                                                    <table id="appointmenttable" class="table table-hover table-borderless" style="width:100%;">
                                                                        <thead class="bg-light">
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>Time</th>
                                                                                <th>Doctor</th>
                                                                                <th>Status</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            if (isset($_GET['id'])) {
                                                                                $user_id = $_GET['id'];
                                                                                $user = "SELECT a.schedule,a.id,a.starttime,a.status,a.endtime,d.name as dname FROM tbldoctor d INNER JOIN tblappointment a WHERE a.doc_id = d.id AND a.patient_id ='$user_id' ORDER BY a.schedule";
                                                                                $users_run = mysqli_query($conn, $user);

                                                                                if (mysqli_num_rows($users_run) > 0) {
                                                                                    foreach ($users_run as $user) {
                                                                            ?>

                                                                                        <tr>
                                                                                            <td>
                                                                                                <?= date('d-M-Y', strtotime($user['schedule'])) ?></td>
                                                                                            <td><?= $user['starttime'] . ' - ' . $user['endtime'] ?></td>
                                                                                            <td><?= $user['dname'] ?></td>
                                                                                            <td>
                                                                                                <?php
                                                                                                if ($user['status'] == 'Treated') {
                                                                                                    echo $user['status'] = '<span class="badge badge-primary">Treated</span>';
                                                                                                } else if ($user['status'] == 'Confirmed') {
                                                                                                    echo $user['status'] = '<span class="badge badge-success">Confirmed</span>';
                                                                                                } else if ($user['status'] == 'Pending') {
                                                                                                    echo $user['status'] = '<span class="badge badge-warning">Pending</span>';
                                                                                                } else if ($user['status'] == 'Cancelled') {
                                                                                                    echo $user['status'] = '<span class="badge badge-danger">Cancelled</span>';
                                                                                                } else {
                                                                                                    echo $user['status'] = '<span class="badge badge-secondary">Reschedule</span>';
                                                                                                }

                                                                                                ?>
                                                                                            </td>
                                                                                        </tr>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                                <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                                                                    <table id="paymenttable" class="table table-hover table-borderless" style="width:100%;">
                                                                        <thead class="bg-light">
                                                                            <tr>
                                                                                <th class="bg-light">Date & Time</th>
                                                                                <th class="bg-light">Reference No.</th>
                                                                                <th class="bg-light">Amount</th>
                                                                                <th class="bg-light">Status</th>
                                                                                <th class="bg-light">Method</th>
                                                                                <th class="bg-light">Transaction ID</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            if (isset($_GET['id'])) {
                                                                                $user_id = $_GET['id'];
                                                                                $user = "SELECT * FROM payments WHERE patient_id='$user_id'";

                                                                                $users_run = mysqli_query($conn, $user);

                                                                                if (mysqli_num_rows($users_run) > 0) {
                                                                                    foreach ($users_run as $row) {
                                                                            ?>

                                                                                        <tr>
                                                                                            <td><?= date('Y-m-d h:i A', strtotime($row['created_at'])) ?></td>
                                                                                            <td><?= $row['ref_id'] ?></td>
                                                                                            <td>₱ <?= $row['amount'] ?></td>
                                                                                            <td><?= $row['payment_status'] ?></td>
                                                                                            <td><span class="badge badge-warning"><?= $row['method'] ?></span></td>
                                                                                            <td><?= $row['txn_id'] ?></td>
                                                                                        </tr>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                                <div class="tab-pane fade" id="prescription" role="tabpanel" aria-labelledby="prescription-tab">
                                                                    <table id="prescriptiontable" class="table table-hover table-borderless" style="width:100%;">
                                                                        <thead class="bg-light">
                                                                            <tr>
                                                                                <th class="bg-light">Date</th>
                                                                                <th class="bg-light">Medicine</th>
                                                                                <th class="bg-light">Dose</th>
                                                                                <th class="bg-light">Duration</th>
                                                                                <th class="bg-light">Advise</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            if (isset($_GET['id'])) {
                                                                                $i = 1;
                                                                                $user_id = $_GET['id'];
                                                                                $user = "SELECT * FROM prescription WHERE patient_id='$user_id'";

                                                                                $users_run = mysqli_query($conn, $user);

                                                                                if (mysqli_num_rows($users_run) > 0) {
                                                                                    foreach ($users_run as $user) {
                                                                            ?>

                                                                                        <tr>
                                                                                            <td><?= date('d-M-Y', strtotime($user['date'])) ?></td>
                                                                                            <td><?= $user['medicine'] ?></td>
                                                                                            <td><?= $user['dose'] ?></td>
                                                                                            <td><?= $user['duration'] ?></td>
                                                                                            <td><?= $user['advice'] ?></td>
                                                                                        </tr>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="card-header border-bottom-0">
                                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#AddDentalModal">
                                                                <i class="fa fa-plus"></i> &nbsp;&nbsp;Add Dental History</button>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover table-borderless" style="width:100%;">
                                                                    <thead class="bg-light">
                                                                        <tr>
                                                                            <th style="width:1%;">#</th>
                                                                            <th>Previous Dentist</th>
                                                                            <th>Last Dental Visit</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        if (isset($_GET['id'])) {
                                                                            $i = 1;
                                                                            $user_id = $_GET['id'];
                                                                            $user = "SELECT * FROM dental_history WHERE patient_id='$user_id'";

                                                                            $users_run = mysqli_query($conn, $user);

                                                                            while ($user = mysqli_fetch_array($users_run)) {
                                                                        ?>
                                                                                <tr>
                                                                                    <td><?php echo $i++; ?></td>
                                                                                    <td><?= $user['dentist'] ?></td>
                                                                                    <td><?= $user['visit'] ?></td>
                                                                                    <td>
                                                                                        <button data-id="<?= $user['id'] ?>" class="btn btn-sm btn-info editDentalbtn"><i class="fas fa-edit"></i></button>
                                                                                        <button data-id="<?= $user['id'] ?>" class="btn btn-danger btn-sm deleteDentalbtn"><i class="far fa-trash-alt"></i></button>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="card-header border-bottom-0">
                                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#AddMedicalModal">
                                                                <i class="fa fa-plus"></i> &nbsp;&nbsp;Add Medical History</button>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover table-borderless" style="width:100%;">
                                                                    <thead class="bg-light">
                                                                        <tr>
                                                                            <th style="width:1%;">#</th>
                                                                            <th>Allergies</th>
                                                                            <th>Illnesses</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        if (isset($_GET['id'])) {
                                                                            $i = 1;
                                                                            $user_id = $_GET['id'];
                                                                            $user = "SELECT * FROM medical_record WHERE patient_id='$user_id'";

                                                                            $users_run = mysqli_query($conn, $user);

                                                                            while ($user = mysqli_fetch_array($users_run)) {
                                                                        ?>
                                                                                <tr>
                                                                                    <td><?php echo $i++; ?></td>
                                                                                    <td><?= $user['allergy'] ?></td>
                                                                                    <td><?= $user['med'] ?></td>
                                                                                    <td>
                                                                                        <button data-id="<?= $user['id'] ?>" class="btn btn-sm btn-info editMedicalbtn"><i class="fas fa-edit"></i></button>
                                                                                        <button data-id="<?= $user['id'] ?>" class="btn btn-danger btn-sm deleteMedicalbtn"><i class="far fa-trash-alt"></i></button>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="treatment" role="tabpanel" aria-labelledby="treatment-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table id="treatmenttable" class="table table-hover table-borderless" style="width:100%;">
                                                        <thead class="bg-light">
                                                            <tr>
                                                                <th class="text-center">#</th>
                                                                <th>Date Visit</th>
                                                                <th>Treatment</th>
                                                                <th>Teeth No./s</th>
                                                                <th>Description</th>
                                                                <th>Fees</th>
                                                                <th>Remarks</th>
                                                                <th class="bg-light">Attachment</th>
                                                                <th class="bg-light">Download</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($_GET['id'])) {
                                                                $i = 1;
                                                                $user_id = $_GET['id'];
                                                                $sql = "SELECT CONCAT(p.fname,'',p.lname) as pname,t.id,t.teeth,t.complaint,t.treatment,t.fees,t.file_name,t.remarks,s.day FROM treatment t INNER JOIN tblpatient p ON t.patient_id = p.id INNER JOIN schedule s ON s.id=t.visit WHERE t.patient_id='$user_id'";

                                                                $users_run = mysqli_query($conn, $sql);

                                                                if (mysqli_num_rows($users_run) > 0) {
                                                                    foreach ($users_run as $row) {
                                                            ?>

                                                                        <tr>
                                                                            <td style="width:10px; text-align:center;"><?php echo $i++; ?></td>
                                                                            <td><?= date('d-M-Y', strtotime($row['day'])); ?></td>
                                                                            <td><?= $row['treatment'] ?></td>
                                                                            <td><?= $row['teeth'] ?></td>
                                                                            <td><?= $row['complaint'] ?></td>
                                                                            <td><?= $row['fees'] ?></td>
                                                                            <td><?= $row['remarks'] ?></td>
                                                                            <?php if (empty($row['file_name'])) {
                                                                                echo '<td>N/A</td><td>N/A</td>';
                                                                            } else {
                                                                                echo '<td><a href="../upload/documents/' . $row['file_name'] . '" target="_blank">View</a></td>
<td><a href="../upload/documents/' . $row['file_name'] . '" download>Download</a></td>';
                                                                            }
                                                                            ?>
                                                                        </tr>
                                                            <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/scripts.php'); ?>
    <script>
        $(document).ready(function() {

            $('#checkBtn').click(function() {
                checked = $("input[type=checkbox]:checked").length;

                if (!checked) {
                    alert("Please, check None option if the patient does not have illness ");
                    return false;
                }
            });

            $('#checkBtn2').click(function() {
                checked = $("input[type=checkbox]:checked").length;

                if (!checked) {
                    alert("Please, check None option if the patient does not have illness ");
                    return false;
                }
            });

            var table1 = $('#appointmenttable').DataTable({
                responsive: true,
                searching: true,
                paging: true,
                info: true,
            });
            var table2 = $('#prescriptiontable').DataTable({
                responsive: true,
                searching: true,
                paging: true,
                info: true,
            });
            var table3 = $('#treatmenttable').DataTable({
                responsive: true,
            });
            var table4 = $('#paymenttable').DataTable({
                responsive: true,
                searching: true,
                paging: true,
                info: true,
            });

            $('.nav-pills a').on('shown.bs.tab', function(event) {
                var tabID = $(event.target).attr('data-target');
                if (tabID === '#appointment') {
                    table1.columns.adjust().responsive.recalc();
                }
                if (tabID === '#prescription') {
                    table2.columns.adjust().responsive.recalc();
                }
                if (tabID === '#payment') {
                    table4.columns.adjust().responsive.recalc();
                }
            });


            $('.nav-tabs a').on('shown.bs.tab', function(event) {
                var tabID = $(event.target).attr('data-target');
                if (tabID === '#treatment') {
                    table3.columns.adjust().responsive.recalc();
                }
            });

            $(document).on('click', '.deleteDentalbtn', function() {
                var userid = $(this).data('id');

                if (confirm("Are you sure you want to delete this data?")) {
                    $.ajax({
                        type: "post",
                        url: "medical_action.php",
                        data: {
                            'delete_dental': true,
                            'user_id': userid,
                        },
                        success: function(response) {
                            location.reload();
                        }
                    });
                }
            });
            $(document).on('click', '.editDentalbtn', function() {
                var userid = $(this).data('id');

                $.ajax({
                    type: "post",
                    url: "medical_action.php",
                    data: {
                        'dental_editbtn': true,
                        'user_id': userid,
                    },
                    success: function(response) {
                        $.each(response, function(key, value) {
                            $('#edit_id').val(value['id']);
                            $('#patient_id').val(value['patient_id']);
                            $('#edit_dentist').val(value['dentist']);
                            $('#edit_visit').val(value['visit']);
                            $('#EditDentalModal').modal('show');
                        });
                    }
                });

            });
            $(document).on('click', '.deleteMedicalbtn', function() {
                var userid = $(this).data('id');

                if (confirm("Are you sure you want to delete this data?")) {
                    $.ajax({
                        type: "post",
                        url: "medical_action.php",
                        data: {
                            'delete_medical': true,
                            'user_id': userid,
                        },
                        success: function(response) {
                            location.reload();
                        }
                    });
                }
            });

            $(document).on('click', '.editMedicalbtn', function() {
                var userid = $(this).data('id');
                $('#EditMedicalModal').modal('show');

            });
        });
    </script>
    <?php include('includes/footer.php'); ?>