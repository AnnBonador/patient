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
    <div class="modal fade" id="AddScheduleModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add Schedule</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="schedule_action.php" method="POST">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Select Doctor</label>
                    <span class="text-danger">*</span>
                    <select class="form-control dentist" name="select_dentist" id="preferredDentist" style="width: 100%;" required>
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
                    <label for="days">Select Days:</label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="monday" name="days[]" value="Monday">
                      <label class="form-check-label" for="monday">Monday</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="tuesday" name="days[]" value="Tuesday">
                      <label class="form-check-label" for="tuesday">Tuesday</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="wednesday" name="days[]" value="Wednesday">
                      <label class="form-check-label" for="wednesday">Wednesday</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="thursday" name="days[]" value="Thursday">
                      <label class="form-check-label" for="thursday">Thursday</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="friday" name="days[]" value="Friday">
                      <label class="form-check-label" for="friday">Friday</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="saturday" name="days[]" value="Saturday">
                      <label class="form-check-label" for="saturday">Saturday</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="sunday" name="days[]" value="Sunday">
                      <label class="form-check-label" for="sunday">Sunday</label>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Appointment Start Time</label>
                    <span class="text-danger">*</span>
                    <div class="input-group date" id="starttime" data-target-input="nearest">
                      <input type="text" autocomplete="off" name="start_time" class="form-control datetimepicker-input" required data-target="#starttime" />
                      <div class="input-group-append" data-target="#starttime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Appointment End Time</label>
                    <span class="text-danger">*</span>
                    <div class="input-group date" id="endtime" data-target-input="nearest">
                      <input type="text" autocomplete="off" name="end_time" class="form-control datetimepicker-input" required data-target="#endtime" />
                      <div class="input-group-append" data-target="#endtime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Appointment Duration</label>
                    <span class="text-danger">*</span>
                    <select class="form-control duration" name="select_duration" required>
                      <option value="15">15 minutes</option>
                      <option value="20">20 minutes</option>
                      <option value="30">30 minutes</option>
                      <option value="45">45 minutes</option>
                      <option value="60">60 minutes</option>
                      <option value="80">80 minutes</option>
                      <option value="120">120 minutes</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>


            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="insert_schedule" class="btn btn-primary submit">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <!--Edit Modal-->
    <div class="modal fade" id="EditScheduleModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Schedule</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="schedule_action.php" method="POST">
            <div class="modal-body">
              <div class="row">
                <input type="hidden" name="edit_id" id="edit_id">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Select Doctor</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2 dentist" name="select_dentist" id="edit_dentist" style="width: 100%;" required readonly>
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
                      } else {
                        ?>
                        <option value="">No Record Found"</option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="days">Select Days:</label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="monday" name="days[]" value="Monday">
                      <label class="form-check-label" for="monday">Monday</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="tuesday" name="days[]" value="Tuesday">
                      <label class="form-check-label" for="tuesday">Tuesday</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="wednesday" name="days[]" value="Wednesday">
                      <label class="form-check-label" for="wednesday">Wednesday</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="thursday" name="days[]" value="Thursday">
                      <label class="form-check-label" for="thursday">Thursday</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="friday" name="days[]" value="Friday">
                      <label class="form-check-label" for="friday">Friday</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="saturday" name="days[]" value="Saturday">
                      <label class="form-check-label" for="saturday">Saturday</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="sunday" name="days[]" value="Sunday">
                      <label class="form-check-label" for="sunday">Sunday</label>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Appointment Start Time</label>
                    <span class="text-danger">*</span>
                    <div class="input-group date" id="edit_stime" data-target-input="nearest">
                      <input type="text" autocomplete="off" name="start_time" class="form-control datetimepicker-input" required data-target="#edit_stime" />
                      <div class="input-group-append" data-target="#edit_stime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Appointment End Time</label>
                    <span class="text-danger">*</span>
                    <div class="input-group date" id="edit_etime" data-target-input="nearest">
                      <input type="text" autocomplete="off" name="end_time" class="form-control datetimepicker-input" required data-target="#edit_etime" />
                      <div class="input-group-append" data-target="#edit_etime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Appointment Duration</label>
                    <span class="text-danger">*</span>
                    <select class="form-control" name="select_duration" id="edit_duration" required>
                      <option value="15">15 minutes</option>
                      <option value="20">20 minutes</option>
                      <option value="30">30 minutes</option>
                      <option value="45">45 minutes</option>
                      <option value="60">60 minutes</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" name="update_sched" class="btn btn-primary submit1">Submit</button>
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
            <h4 class="modal-title">Delete Schedule</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="schedule_action.php" method="POST">
            <div class="modal-body">
              <input type="hidden" name="delete_id" id="delete_id">
              <p> Do you want to delete this data?</p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" name="deletedata" class="btn btn-primary ">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Schedule</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
                <li class="breadcrumb-item active">Schedule</li>
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
              include('../../message.php');
              ?>
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">Time Schedule List</h3>
                  <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddScheduleModal">
                    <i class="fa fa-plus"></i> &nbsp;&nbsp;Add Schedule</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="sched_tbl" class="table table-borderless table-hover" style="width: 100%;">
                    <thead class="bg-light">
                      <tr>
                        <th class="export">Dentist</th>
                        <th class="export" data-sort='YYYYMMDD'>Day</th>
                        <th class="export">Start Time</th>
                        <th class="export">End Time</th>
                        <th class="export">Duration</th>
                        <th width="15%">Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th class="search">Dentist</th>
                        <th class="search">Day</th>
                        <th class="search">Start Time</th>
                        <th class="search">End Time</th>
                        <th class="search">Duration</th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
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
  <script>
    $(document).ready(function() {
      var table = $('#sched_tbl').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "searching": true,
        "paging": true,
        "responsive": true,
        "pagingType": "simple",
        "buttons": [{
            extend: 'copyHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-clipboard"></i>  Copy',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'csvHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-csv"></i>  CSV',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'excel',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-excel"></i>  Excel',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'pdfHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-pdf"></i>  PDF',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'print',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-print"></i>  Print',
            exportOptions: {
              columns: '.export'
            }
          }
        ],
        "language": {
          'search': '',
          'searchPlaceholder': "Search...",
          'emptyTable': "No results found",
        },
        "ajax": {
          "url": "schedule_table.php",
        },
        "columns": [{
            "data": 'doc_name',
          },
          {
            "data": "day",
          },
          {
            "data": "starttime"
          },
          {
            "data": "endtime"
          },
          {
            "data": "duration"
          },
          {
            "data": 'id',
            render: function(data, type, row) {
              return '<button data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <input type="hidden" name="del_image" value="' + data + '"><button data-id="' + data + '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>';
            }
          },
        ],
        "order": [
          [0, 'asc'],
          [1, 'desc'],
        ],
        "initComplete": function() {
          this.api().columns().every(function() {
            var that = this;
            $('input', this.footer()).on('keyup change clear', function() {
              if (that.search() !== this.value) {
                that
                  .search(this.value)
                  .draw();
              }
            });
          });
        },
      });
      $('#sched_tbl tfoot th.search').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" class="search-input form-control form-control-sm"/>');
      });
    });

    let getTime = (m) => {
      return m.minutes() + m.hours() * 60;
    }

    $('.submit').on('click', () => {
      let timeFrom = $('input[name=start_time]').val(),
        timeTo = $('input[name=end_time]').val();

      // Check if any checkbox is selected
      const isDaySelected = $('input[name="days[]"]:checked').length > 0;

      if (!isDaySelected) {
        alert('Please select at least one day.');
        return false; // Prevent form submission
      }

      if (!timeFrom || !timeTo) {
        alert('Select time');
        return false; // Prevent form submission
      }

      timeFrom = moment(timeFrom, 'hh:mm a');
      timeTo = moment(timeTo, 'hh:mm a');

      if (getTime(timeFrom) >= getTime(timeTo)) {
        alert('Start time must not be greater than or equal to End time');
        return false; // Prevent form submission
      }

      return true; // Allow form submission
    });


    $('.submit1').on('click', () => {
      let timeFrom = $('#edit_stime').find("input").val(),
        timeTo = $('#edit_etime').find("input").val();

      if (!timeFrom || !timeTo) {
        alert('Select time');
        return
      }

      timeFrom = moment(timeFrom, ["h:mm A"]).format("HH:mm");
      timeTo = moment(timeTo, ["h:mm A"]).format("HH:mm");
      if (timeFrom >= timeTo) {
        alert('Start time must not greater than or equal to End time');
        return false;
      } else {
        return true;
      }
    });

    //MIN DATE TOMMOROW
    var today = new Date();
    var dd = today.getDate() + 1;
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10) {
      dd = '0' + dd
    }
    if (mm < 10) {
      mm = '0' + mm
    }

    today = yyyy + '-' + mm + '-' + dd;

    $(document).ready(function() {

      initializeSelect2(".dentist", "Select Dentist");
      initializeSelect2(".duration", "Select Duration");

      initializeDatetimePicker('#starttime');
      initializeDatetimePicker('#endtime');
      initializeDatetimePicker('#edit_stime');
      initializeDatetimePicker('#edit_etime');

      $(document).on('click', '.viewbtn', function() {
        var userid = $(this).data('id');

        $.ajax({
          url: 'patient_action.php',
          type: 'post',
          data: {
            userid: userid
          },
          success: function(response) {

            $('.patient_viewing_data').html(response);
            $('#ViewPatientModal').modal('show');
          }
        });
      });

      $(document).on('click', '.editbtn', function() {
        var schedid = $(this).data('id');

        $.ajax({
          type: 'post',
          url: "schedule_action.php",
          data: {
            'checking_editbtn': true,
            'sched_id': schedid,
          },
          success: function(response) {
            $.each(response, function(key, value) {
              $('#edit_id').val(value['id']);
              $('#edit_dentist').val(value['doc_id']).trigger('change');
              $("#edit_dentist").select2({
                disabled: 'readonly'
              });

              populateDaysForEdit(value['day']);

              $('#edit_stime').find("input").val(value['starttime']);
              $("#edit_etime").find("input").val(value['endtime']);
              $('#edit_duration').val(value['duration']);
            });

            $('#EditScheduleModal').modal('show');
          }
        });
      });

      $(document).on('click', '.deletebtn', function() {
        var user_id = $(this).data('id');
        $('#delete_id').val(user_id);
        $('#deletemodal').modal('show');

      });

    });

    function populateDaysForEdit(selectedDays) {
      days = JSON.parse(selectedDays);
      $('input[name="days[]"]').prop('checked', false);

      days.forEach(day => {
        $(`input[name="days[]"][value="${day}"]`).prop('checked', true);
      });
    }
  </script>
  <?php include('../../includes/footer.php'); ?>