<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Backup Database</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Backup Database</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            include('../../message.php');
                            ?>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Database details</h3>
                                </div>
                                <form action="database_backup.php" method="post" id="" onsubmit="return validateForm();">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="">Host</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" class="form-control" name="server" id="server" placeholder="Enter Server Name EX: Localhost" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Database Username</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" class="form-control" name="username" id="username" placeholder="Enter Database Username EX: root" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Database Password</label>
                                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Database Password">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Database Name</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" class="form-control" name="dbname" id="dbname" placeholder="Enter Database Name" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" name="backupnow" class="btn btn-primary" onClick="return checkForm(this);">Initiate Backup</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('../../includes/scripts.php'); ?>
        <?php include('../../includes/footer.php'); ?>