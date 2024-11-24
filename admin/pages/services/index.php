<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="modal fade" id="AddDocumentrModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Services</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="services_action.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Service Name</label><span class="text-danger">*</span>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Article Title</label><span class="text-danger">*</span>
                                        <input type="text" name="art_title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea id="description" name="description" required></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Upload Image</label><span class="text-danger">*</span>
                                        <input type="file" name="files" required>
                                        <span class="direct-chat-timestamp text-sm">Recommended Size : 700x500</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="insert_services" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="EditServiceModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Service</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="services_action.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" id="edit_id" name="edit_id">
                                    <div class="form-group">
                                        <label>Service Name</label><span class="text-danger">*</span>
                                        <input type="text" name="title" id="edit_title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Article Title</label><span class="text-danger">*</span>
                                        <input type="text" name="art_title" id="edit_art-title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea name="description" id="edit_description" required></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Upload Image</label><span class="text-danger">*</span>
                                        <input type="file" id="edit_simage" name="files">
                                        <input type="hidden" name="old_image" id="old_image" />
                                        <span class="direct-chat-timestamp text-sm">Recommended Size : 700x500</span>
                                        <div id="uploaded_image"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="update_services" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="DeleteServiceModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Service</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="services_action.php" method="POST">
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
                            <h1>Services</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Services</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php include('../../message.php'); ?>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Services List</h3>
                                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddDocumentrModal">
                                        <i class="fa fa-plus"></i> &nbsp;&nbsp;Add Services</button>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-borderless table-hover" style="width:100%;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th width="30">Image</th>
                                                <th>Services</th>
                                                <th>Content</th>
                                                <th width="50">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM services";
                                            $query_run = mysqli_query($conn, $sql);

                                            while ($row = mysqli_fetch_array($query_run)) {
                                            ?>
                                                <tr>
                                                    <td><img src="../../../upload/service/<?= $row['image'] ?>" class="img-fluid img-thumbnail" width="100" alt=""></td>
                                                    <td><?= $row['title'] ?></td>
                                                    <td><?= $row['description'] ?></td>
                                                    <td>
                                                        <button data-id="<?= $row['id'] ?>" class="btn btn-sm btn-info editServicebtn"><i class="fas fa-edit"></i></button>
                                                        <input type="hidden" name="del_image" value="<?= $row['image']; ?>">
                                                        <button data-id="<?= $row['id'] ?>" class="btn btn-danger btn-sm deleteServicebtn"><i class="far fa-trash-alt"></i></button>
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

    <?php include('../../includes/scripts.php'); ?>
    <script>
        $(document).ready(function() {

            $('#description').summernote({
                placeholder: 'Raleway for Title and Open Sans 16 for body ',
                height: 250,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ol', 'ul', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                ],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Open Sans', 'Raleway'],
                fontNamesIgnoreCheck: ['Open Sans', 'Raleway'],
            })
            $('#edit_description').summernote({
                placeholder: 'Raleway for Title and Open Sans 16 for body ',
                height: 250,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ol', 'ul', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                ],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Open Sans', 'Raleway'],
                fontNamesIgnoreCheck: ['Open Sans', 'Raleway'],
            })

            $('#description').summernote('fontName', 'Open Sans');
            $('#edit_description').summernote('fontName', 'Open Sans');


            $(document).on('click', '.editServicebtn', function() {
                var userid = $(this).data('id');

                $.ajax({
                    type: "POST",
                    url: "services_action.php",
                    data: {
                        'checking_services': true,
                        'user_id': userid,
                    },
                    success: function(response) {
                        $.each(response, function(key, value) {
                            $('#edit_id').val(value['id']);
                            $('#edit_title').val(value['title']);
                            $('#edit_art-title').val(value['article_title']);
                            $('#edit_description').summernote('code', value['description']);
                            $('#uploaded_image').html('<img src="../../../upload/service/' + value['image'] + '" class="img-fluid img-thumbnail" width="200" />');
                            $('#old_image').val(value['image']);
                            $('#EditServiceModal').modal('show');
                        });

                    }
                });
            });

            $(document).on('click', '.deleteServicebtn', function() {
                var user_id = $(this).data('id');
                $('#delete_id').val(user_id);
                $('#DeleteServiceModal').modal('show');
            });

        });
    </script>
    <?php include('../../includes/footer.php'); ?>