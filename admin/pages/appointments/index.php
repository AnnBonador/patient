<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Add Modal -->
    <div class="modal fade" id="AddAppointmentModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add Appointment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="appointment_action.php" method="POST">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Select Patient</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2 patient" name="select_patient" id="selectedPatient" style="width: 100%;" required>
                      <option selected disabled value="">Select Patient</option>
                      <?php
                      if (isset($_GET['id'])) {
                        echo $id = $_GET['id'];
                      }
                      $sql = "SELECT * FROM tblpatient";
                      $query_run = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                      ?>

                          <option value="<?php echo $row['id']; ?>">
                            <?php echo $row['fname'] . ' ' . $row['lname']; ?></option>
                        <?php
                        }
                      } else {
                        ?>
                        <option value="">No Record Found"</option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Select Doctor</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2 dentist" name="select_dentist" id="preferredDentist" style="width: 100%;" required>
                      <option selected disabled value="">Select Dentist</option>
                      <?php
                      if (isset($_GET['id'])) {
                        echo $id = $_GET['id'];
                      }
                      $sql = "SELECT * FROM tbldoctor WHERE status='1'";
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
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Appontment Date</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2" name="scheddate" id="preferredDate" style="width: 100%;" required>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Appontment Time</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2" name="schedTime" id="preferredTime" style="width:100%;" required>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Service</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2" multiple="multiple" name="service[]" id="service" style="width: 100%;" required>
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
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Appointment Status</label>
                    <span class="text-danger">*</span>
                    <select class="form-control custom-select" name="status" id="show-checkbox" required>
                      <option value="Confirmed">Confirmed</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="color">Color</label>
                    <select name="color" class="form-control custom-select" id="color">
                      <option style="color:#f39c12;" value="#f39c12">Yellow</option>
                      <option style="color:#00c0ef;" value="#00c0ef"> Aqua</option>
                      <option style="color:#0073b7;" value="#0073b7"> Blue</option>
                      <option style="color:#00a65a;" value="#00a65a"> Green</option>
                      <option style="color:#FF8C00;" value="#FF8C00"> Orange</option>
                      <option style="color:#3c8dbc;" value="#3c8dbc"> Light Blue</option>
                      <option style="color:#f56954;" value="#f56954"> Red</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="custom-control custom-checkbox" id="show-email1">
                    <input class="custom-control-input" type="checkbox" name="send-email" id="customCheckbox2" checked>
                    <label for="customCheckbox2" class="custom-control-label">Send Email</label>
                  </div>
                </div>
              </div>
            </div>


            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="insert_appointment" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!--View Modal-->
    <div class="modal fade" id="ViewScheduleModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Patient Info</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="patient_viewing_data">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


    <!--Edit Modal-->
    <div class="modal fade" id="EditAppointmentModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Appointment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="appointment_action.php" method="POST">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <input type="hidden" name="select_patient" id="edit_patient_id">
                    <input type="hidden" name="select_dentist" id="edit_dentist_id">
                    <input type="hidden" id="edit_schedule">
                    <label>Select Patient</label>
                    <span class="text-danger">*</span>
                    <select class="select2 patient" name="" id="edit_patient" style="width:100%;" required disabled>
                      <?php
                      if (isset($_GET['id'])) {
                        echo $id = $_GET['id'];
                      }
                      $sql = "SELECT * FROM tblpatient";
                      $query_run = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                      ?>

                          <option value="<?php echo $row['id']; ?>">
                            <?php echo $row['fname'] . ' ' . $row['lname']; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Select Doctor</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2 dentist" name="" id="edit_dentist" style="width:100%;" required disabled>
                      <?php
                      if (isset($_GET['id'])) {
                        echo $id = $_GET['id'];
                      }
                      $sql = "SELECT * FROM tbldoctor WHERE status='1'";
                      $doctor_query_run = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($doctor_query_run) > 0) {
                        foreach ($doctor_query_run as $row) {
                      ?>

                          <option value="<?php echo $row['id']; ?>">
                            <?php echo $row['name']; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Appontment Date</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2" name="scheddate" id="edit_sched" style="width:100%;" required>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Appontment Time</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2" name="schedTime" id="edit_schedTime" style="width:100%;" required>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Service</label>
                    <span class="text-danger">*</span>
                    <select class="select2" multiple="multiple" name="service[]" id="edit_reason" style="width: 100%;" required>
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
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Appointment Status</label>
                    <span class="text-danger">*</span>
                    <select class="form-control custom-select" name="status" id="edit_status" id="show-checkbox" required>
                      <option value="Confirmed">Confirmed</option>
                      <option value="Cancelled">Cancelled</option>
                      <option value="Reschedule">Reschedule</option>
                      <option value="Treated">Treated</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="color">Color</label>
                    <select name="color" class="form-control custom-select" id="edit_color">
                      <option style="color:#f39c12;" value="#f39c12">Yellow</option>
                      <option style="color:#00c0ef;" value="#00c0ef"> Aqua</option>
                      <option style="color:#0073b7;" value="#0073b7"> Blue</option>
                      <option style="color:#00a65a;" value="#00a65a"> Green</option>
                      <option style="color:#FF8C00;" value="#FF8C00"> Orange</option>
                      <option style="color:#3c8dbc;" value="#3c8dbc"> Light Blue</option>
                      <option style="color:#f56954;" value="#f56954"> Red</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="custom-control custom-checkbox" id="show-email2">
                    <input class="custom-control-input ck" type="checkbox" id="customCheckbox3" name="send-email" disabled>
                    <label for="customCheckbox3" class="custom-control-label">Send Email</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" name="update_appointment" class="btn btn-primary submit">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/edit modal -->

    <!-- delete modal pop up modal -->
    <div class="modal fade" id="deletemodal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Delete Appointment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="appointment_action.php" method="POST">
            <div class="modal-body">
              <input type="hidden" name="delete_id" id="delete_id">
              <p> Do you want to delete this Appointment?</p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" name="deletedata" class="btn btn-primary ">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/delete modal -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <section class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Appointment</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
                <li class="breadcrumb-item active">Appointment</li>
              </ol>
            </div> <!-- /.col -->
          </div> <!-- /.row -->
        </section><!-- /.container-fluid -->
      </div>
      <!--/.content-header-->


      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <?php
              include('../../message.php');
              ?>
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">Appointment List</h3>
                  <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddAppointmentModal">
                    <i class="fa fa-plus"></i> &nbsp;&nbsp;Add Appointment</button>
                </div>
                <div class="col-md-12 mt-4">
                  <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="all-tab" data-toggle="tab" data-target="#all" role="tab" aria-controls="all" aria-selected="true">All</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="confirmed-tab" data-toggle="tab" data-target="#confirmed" role="tab" aria-controls="confirmed" aria-selected="false">Confirmed</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="treated-tab" data-toggle="tab" data-target="#treated" role="tab" aria-controls="treated-tab" aria-selected="false">Treated</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="cancelled-tab" data-toggle="tab" data-target="#cancelled" role="tab" aria-controls="cancelled-tab" aria-selected="false">Cancelled</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="reschedule-tab" data-toggle="tab" data-target="#reschedule" aria-controls="reschedule-tab" aria-selected="false">Reschedule</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div id="all" class="tab-pane fade show active" role="tabpanel" aria-labelledby="all-tab">
                      <table id="apptmttbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Patient</th>
                            <th class="export">Date Submitted</th>
                            <th class="export">Appointment Date</th>
                            <th class="export">Start Time</th>
                            <th class="export">End Time</th>
                            <th class="export">Status</th>
                            <th width="15%">Action</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    <div id="confirmed" class="tab-pane fade" role="tabpanel" aria-labelledby="confirmed-tab">
                      <table id="confirmedtbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Patient</th>
                            <th class="export">Date Submitted</th>
                            <th class="export">Appointment Date</th>
                            <th class="export">Start Time</th>
                            <th class="export">End Time</th>
                            <th class="export">Status</th>
                            <th width="15%">Action</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    <div id="treated" class="tab-pane fade" role="tabpanel" aria-labelledby="treated-tab">
                      <table id="treatedtbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Patient</th>
                            <th class="export">Date Submitted</th>
                            <th class="export">Appointment Date</th>
                            <th class="export">Start Time</th>
                            <th class="export">End Time</th>
                            <th class="export">Status</th>
                            <th width="15%">Action</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    <div id="cancelled" class="tab-pane fade" role="tabpanel" aria-labelledby="cancelled-tab">
                      <table id="cancelledtbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Patient</th>
                            <th class="export">Date Submitted</th>
                            <th class="export">Appointment Date</th>
                            <th class="export">Start Time</th>
                            <th class="export">End Time</th>
                            <th class="export">Status</th>
                            <th width="15%">Action</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    <div id="reschedule" class="tab-pane fade" role="tabpanel" aria-labelledby="reschedule-tab">
                      <table id="rescheduletbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Patient</th>
                            <th class="export">Date Submitted</th>
                            <th class="export">Appointment Date</th>
                            <th class="export">Start Time</th>
                            <th class="export">End Time</th>
                            <th class="export">Status</th>
                            <th width="15%">Action</th>
                          </tr>
                        </thead>
                      </table>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div> <!-- /.container -->
  </div> <!-- /.content-wrapper -->

  </div>

  <?php include('../../includes/scripts.php'); ?>
  <script src="appointment.js"></script>
  <?php include('../../includes/footer.php'); ?>