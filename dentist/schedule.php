<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
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
            <input type="hidden" name="select_dentist" value="<?php echo $_SESSION['auth_user']['user_id'];?>">
              <div class="col-sm-12">              
                <div class="form-group">
                  <label>Day</label>
                  <span class="text-danger">*</span>
                  <input type="date" name="select_day" id="select_day_sched" class="form-control" required>
                </div>
              </div>    
              <div class="col-sm-6">              
                <div class="form-group">
                    <label>Appointment Start Time</label>
                    <span class="text-danger">*</span>
                    <div class="input-group date" id="starttime" data-target-input="nearest">
                      <input type="text" autocomplete="off" name="start_time" class="form-control datetimepicker-input" required data-target="#starttime"/>
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
                      <input type="text" autocomplete="off" name="end_time" class="form-control datetimepicker-input" required data-target="#endtime"/>
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
                  <select class="form-control" name="select_duration" required >
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
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="insert_schedule" class="btn btn-primary submit">Submit</button>
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
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
        include('message.php');
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
                  <th class="export">Day</th>
                  <th class="export">Start Time</th>
                  <th class="export">End Time</th>
                  <th class="export">Duration</th>
                  <!--<th>Action</th>-->
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th class="search">Day</th>
                  <th class="search">Start Time</th>
                  <th class="search">End Time</th>
                  <th class="search">Duration</th>
                  <!--<th></th>-->
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

<?php include('includes/scripts.php');?>
<script>
  var table = $('#sched_tbl').DataTable( {
      "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      "processing": true,
      "searching": true,
      "paging": true,
      "responsive":true,
      "pagingType": "simple",
      "buttons": [
            {
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
          "type": "POST",
          "data": {
            "doctor_id": <?php echo $_SESSION['auth_user']['user_id'] ?>
          }
      },
      "columns": [
        { 
          "data": "day",
          render: function(data,type,row){
            return moment(data).format("DD-MMM-YYYY")
          }
        },
        { "data": "starttime" },
        { "data": "endtime" },
        { "data": "duration" },
      ],
      "order": [
        [1, 'asc'],
      ],
      "initComplete": function () {
        this.api().columns().every( function () {
          var that = this;
          $( 'input', this.footer() ).on( 'keyup change clear', function () {
            if ( that.search() !== this.value ) {
              that
                .search( this.value )
                .draw();
            }
          });
        });
      },
    });
    $('#sched_tbl tfoot th.search').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" class="search-input form-control form-control-sm"/>' );
    } );

    let getTime = (m) => {
    return m.minutes() + m.hours() * 60;
    }

    $('.submit').on('click', () => {
        let timeFrom = $('input[name=start_time]').val(),
            timeTo = $('input[name=end_time]').val();

        if (!timeFrom || !timeTo) {
            alert('Select time');
            return
        }
        timeFrom = moment(timeFrom, 'hh:mm a');
        timeTo = moment(timeTo, 'hh:mm a');

        if (getTime(timeFrom) >= getTime(timeTo)) {
            alert('Start time must not greater than or equal to End time');
            return false;
        } else {
            return true;
        }
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
        if(timeFrom >= timeTo)
        {
          alert('Start time must not greater than or equal to End time');
          return false;
        }
        else{
          return true;
        }
    });
  //MIN DATE TOMMOROW
  var today = new Date();
  var dd = today.getDate()+1;
  var mm = today.getMonth()+1; 
  var yyyy = today.getFullYear();
  if(dd<10){
    dd='0'+dd
  } 
  if(mm<10){
    mm='0'+mm
  } 

  today = yyyy+'-'+mm+'-'+dd;
  document.getElementById("select_day_sched").setAttribute("min", today);
    $(document).ready(function () {

     $(".dentist").select2({
      placeholder: "Select Dentist",
      allowClear: true
      });

      $('#scheddate').datepicker({
        startDate: new Date()
      });

      $('#starttime').datetimepicker({
          format: 'LT'
      });
      $('#endtime').datetimepicker({
          format: 'LT'
      });

});
</script>
<?php include('includes/footer.php');?>