<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<div class="modal fade" id="ViewPatientModal">
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
<div class="content-wrapper">
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Patient</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Patient</li>
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
                <h3 class="card-title">Patient List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="patienttbl" class="table table-borderless table-hover" style="width: 100%;">
                  <thead class="bg-light">
                    <tr>
                      <th class="text-center">Photo</th>
                      <th class="export">Patient</th>
                      <th class="export">Birthday</th>
                      <th class="export">Gender</th>
                      <th class="export">Contact</th>
                      <th class="export">Email</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th class="text-center"></th>
                      <th class="search">Patient</th>
                      <th class="search">Birthday</th>
                      <th class="search">Gender</th>
                      <th class="search">Contact</th>
                      <th class="search">Email</th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
</div>

<?php include('includes/scripts.php');?>
<script>
    var table = $('#patienttbl').DataTable( {
      "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      "processing": true,
      "searching": true,
      "paging": true,
      "responsive":true,
      "pagingType": "simple",
      "autoWidth": false,
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
      "order": [[ 1, "asc" ]],
      "language": {
        'search': '',
        'searchPlaceholder': "Search...",
        'emptyTable': "No results found",
      },
      "ajax": {
        "url": "patient_table.php",
      },
      "columns": [
        {
          "data": 'image',
          render: function(data, type) {
            return '<img src="../upload/patients/'+ data + '" class="img-thumbnail img-circle" width="50" alt="">';
          }
        },
        {
          "data": 'fname',
          render: function(data, type, row) {
            return row.lname + ", " + row.fname;
          }
        },
        { 
          "data": "dob",
          render: function(data,type,row){
            return moment(data).format("DD-MMM-YYYY")
          }
        },
        { "data": "gender" },
        { "data": "phone" },
        { "data": "email" },
        {
          "data": 'id',
          render: function(data, type,row) {
            return '<a href="patient-details.php?id='+ data +'" class="btn btn-sm btn-secondary"><i class="fa fa-eye"></i></a>';
          }
        },
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
    $('#patienttbl tfoot th.search').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" class="search-input form-control form-control-sm"/>' );
    } );

    $(document).ready(function () {

      $(document).on('click', '.viewbtn', function() {       
        var userid = $(this).data('id');

        $.ajax({
        url: 'patient_action.php',
        type: 'post',
        data: {userid: userid},
        success: function(response){ 
          
          $('.patient_viewing_data').html(response);
          $('#ViewPatientModal').modal('show'); 
        }
      });
    });

});
</script>

<?php include('includes/footer.php');?>