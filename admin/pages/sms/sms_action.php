<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['sms_update'])) {
    $sid = $_POST['sid'];
    $token = $_POST['token'];
    $sender = $_POST['sender'];

    $sql = "UPDATE sms_settings SET sid='$sid',token='$token',sender='$sender' WHERE id='1'";
    $query_run = mysqli_query($conn, $sql);
    if ($query_run) {
        $_SESSION['success'] = "SMS Settings Updated Successfully";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "SMS Settings Failed to Update";
        header('Location:index.php');
    }
}
