<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['insert_procedures'])) {
    $services = $_POST['select_services'];
    $procedure = $_POST['procedure'];
    $price = $_POST['price'];

    $sql = "INSERT INTO procedures (service_id,procedures,price) VALUES ('$services','$procedure','$price')";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Procedure Added Successfully";
        header('Location: index.php');
    } else {
        $_SESSION['error'] = "Procedure Failed to Add";
        header('Location: index.php');
    }
}

if (isset($_POST['checking_procedures'])) {
    $id = $_POST['user_id'];
    $result_array = [];

    $sql = "SELECT * FROM procedures WHERE id='$id' ";
    $query_run = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
            array_push($result_array, $row);
        }
        header('Content-type: application/json');
        echo json_encode($result_array);
    } else {
        echo $return = "<h5> No Record Found</h5>";
    }
}

if (isset($_POST['update_procedures'])) {
    $id = $_POST['edit_id'];
    $services = $_POST['select_services'];
    $procedure = $_POST['procedure'];
    $price = $_POST['price'];

    $sql = "UPDATE procedures SET service_id='$services',procedures='$procedure',price='$price' WHERE id='$id'";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Procedure Updated Successfully";
        header('Location: index.php');
    } else {
        $_SESSION['error'] = "Procedure Failed to Update";
        header('Location: index.php');
    }
}


if (isset($_POST['deletedata'])) {
    $id = $_POST['delete_id'];

    $sql = "DELETE FROM procedures WHERE id='$id' ";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Procedures Deleted Successfully";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Procedures Failed to Delete";
        header('Location:index.php');
    }
}
