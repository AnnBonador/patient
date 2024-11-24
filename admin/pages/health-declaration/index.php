<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <div class="modal fade" id="AddQuestionnaireModal" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Questions</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="hd_action.php" method="POST">
            <div class="modal-body">
                <div class="row">    
                    <div class="col-sm-12">              
                        <div class="form-group">
                            <label>Question</label>
                            <span class="text-danger">*</span>
                            <textarea name="questions" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>    
                </div>        
            </div>            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="insert_question" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="EditQuestionnaireModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Questions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <form action="hd_action.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="edit_id" id="edit_id">     
                        <div class="col-sm-12">              
                            <div class="form-group">
                                <label>Question</label>
                                <span class="text-danger">*</span>
                                <textarea name="questions" id="edit_question" rows="4" class="form-control" required></textarea>
                            </div>
                        </div>     
                    </div>         
                </div>     
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="update_question" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="DeleteQuestionnaireModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div> 
            <form action="hd_action.php" method="POST">
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
                <h1>Procedures</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Procedures</li>
                </ol>
            </div>
        </div> 
    </div>
</div>
      
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php include('../../message.php');?>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Questionnaires</h3>
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddQuestionnaireModal">
                        <i class="fa fa-plus"></i> &nbsp;&nbsp;Add Questions</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-borderless table-hover" style="width:100%;">
                        <thead class="bg-light">
                            <tr>
                            <th class="text-center" style="width:20px;">#</th>
                            <th>Health Declaration Questions</th>
                            <th width="50">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $sql = "SELECT * FROM questionnaires";
                            $query_run = mysqli_query($conn, $sql);
                            
                            while($row = mysqli_fetch_array($query_run)){
                            ?>
                            <tr>                       
                            <td style="width:10px; text-align:center;"><?php echo $i++; ?></td>
                            <td><?=$row['questions']?></td>  
                            <td>
                                <button data-id="<?=$row['id']?>"  class="btn btn-sm btn-info editQuestionbtn"><i class="fas fa-edit"></i></button>
                                <button data-id="<?=$row['id']?>" class="btn btn-danger btn-sm deleteServicebtn"><i class="far fa-trash-alt"></i></button>
                            </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
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

<?php include('../../includes/scripts.php');?>
<script>
    $(document).ready(function () {
        $(document).on('click', '.editQuestionbtn', function() {  
            var userid = $(this).data('id');

            $.ajax({
                type: "POST",
                url: "hd_action.php",
                data:
                {
                'checking_question':true,
                'user_id':userid,
                },
                success: function (response) {
                $.each(response, function (key, value){
                    $('#edit_id').val(value['id']);
                    $('#edit_question').val(value['questions']);
                    $('#EditQuestionnaireModal').modal('show');
                });
                    
                }
            });      
        });

        $(document).on('click','.deleteServicebtn', function(){   
        var user_id = $(this).data('id');
        $('#delete_id').val(user_id);
        $('#DeleteQuestionnaireModal').modal('show');
        });

    });
</script>
<?php include('../../includes/footer.php');?>