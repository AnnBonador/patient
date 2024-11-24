<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['insert_question'])) {
    $questions = $_POST['questions'];

    $sql = "INSERT INTO questionnaires (questions) VALUES ('$questions')";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Question Added Successfully";
        header('Location: index.php');
    } else {
        $_SESSION['error'] = "Question Added Unsuccessful";
        header('Location: index.php');
    }
}

if (isset($_POST['checking_question'])) {
    $s_id = $_POST['user_id'];
    $result_array = [];

    $sql = "SELECT * FROM questionnaires WHERE id='$s_id' ";
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

if (isset($_POST['update_question'])) {
    $id = $_POST['edit_id'];
    $questions = $_POST['questions'];

    $sql = "UPDATE questionnaires SET questions='$questions' WHERE id='$id' ";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Question Updated Successfully";
        header('Location: index.php');
    } else {
        $_SESSION['error'] = "Question Updated Unsuccessful";
        header('Location: index.php');
    }
}

if (isset($_POST['deletedata'])) {
    $id = $_POST['delete_id'];

    $sql = "DELETE FROM questionnaires WHERE id='$id' ";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Question Deleted Successfully";
        header('Location: index.php');
    } else {
        $_SESSION['success'] = "Question Deleted Unsuccessful";
        header('Location: index.php');
    }
}
