<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['mail_update'])) {
    $host = $_POST['host'];
    $username = $_POST['u642540313_dentalclinic'];
    $password = $_POST['Bbkoh0810*'];

    $sql = "UPDATE mail_settings SET host='$host',username='$username',password='$password' WHERE id='1'";
    $query_run = mysqli_query($conn, $sql);
    if ($query_run) {
        $_SESSION['success'] = "Mail Settings Updated Successfully";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "mail Settings Failed to Update";
        header('Location:index.php');
    }
}
