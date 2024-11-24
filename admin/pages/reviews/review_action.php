<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['insert_review'])) {
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $review = $_POST['review'];
    $status = $_POST['status'];
    $img = $_FILES['img_profile']['name'];

    if ($img != null) {
        $image_extension = pathinfo($img, PATHINFO_EXTENSION);
        $allowed_file_format = array('jpg', 'png', 'jpeg');
        if (!in_array($image_extension, $allowed_file_format)) {
            $_SESSION['error'] = "Upload valid file. jpg, png";
            header('Location:index.php');
        } else if (($_FILES['img_profile']['size'] > 2000000)) {
            $_SESSION['error'] = "File size exceeds 2MB";
            header('Location:index.php');
        } else {
            $filename = time() . '.' . $image_extension;
            move_uploaded_file($_FILES['img_profile']['tmp_name'], '../../assets/dist/img/testimonials/' . $filename);
        }
    }

    if ($_SESSION['error'] == '') {
        $sql = "INSERT INTO reviews (name,designation,review,status,image) VALUES ('$name','$designation','$review','$status','$filename')";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['success'] = "Review Added Successfully";
            header('Location: index.php');
        } else {
            $_SESSION['error'] = "Review Failed to Add";
            header('Location: index.php');
        }
    }
}

if (isset($_POST['checking_review'])) {
    $id = $_POST['review_id'];
    $result_array = [];

    $sql = "SELECT * FROM reviews WHERE id='$id' ";
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

if (isset($_POST['update_testimonial'])) {
    $id = $_POST['edit_id'];
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $review = $_POST['review'];
    $status = $_POST['status'];
    $old_image = $_POST['old_image'];
    $image = $_FILES['img_profile']['name'];

    $update_filename = "";
    if ($image != null) {
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);
        $allowed_file_format = array('jpg', 'png', 'jpeg');
        if (!in_array($image_extension, $allowed_file_format)) {
            $_SESSION['error'] = "Upload valid file. jpg, png";
            header('Location:index.php');
        } else if (($_FILES['img_profile']['size'] > 2000000)) {
            $_SESSION['error'] = "File size exceeds 2MB";
            header('Location:index.php');
        } else {
            $filename = time() . '.' . $image_extension;
            $update_filename = $filename;
        }
    } else {
        $update_filename = $old_image;
    }
    if ($_SESSION['error'] == '') {
        $sql = "UPDATE reviews SET name='$name',designation='$designation',review='$review',status='$status',image='$update_filename' WHERE id = '$id'";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            if ($image != NULL) {
                if (file_exists('../../assets/dist/img/testimonials/' . $old_image)) {
                    unlink("../../assets/dist/img/testimonials/" . $old_image);
                }
                move_uploaded_file($_FILES['img_profile']['tmp_name'], '../../assets/dist/img/testimonials/' . $update_filename);
            }
            $_SESSION['success'] = "Review Updated Successfully";
            header('Location: index.php');
        } else {
            $_SESSION['error'] = "Review Failed to Update";
            header('Location: index.php');
        }
    }
}

if (isset($_POST['deletedata'])) {
    $id = $_POST['delete_id'];
    $del_image = $_POST['del_image'];

    $check_img_query = " SELECT * FROM reviews WHERE id='$id' LIMIT 1";
    $img_res = mysqli_query($conn, $check_img_query);
    $res_data = mysqli_fetch_array($img_res);
    $image = $res_data['image'];

    $sql = "DELETE FROM reviews WHERE id='$id' LIMIT 1";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        if ($image != NULL) {
            if (file_exists('../../assets/dist/img/testimonials/' . $image)) {
                unlink("../../assets/dist/img/testimonials/" . $image);
            }
        }
        $_SESSION['success'] = "Review Deleted Successfully";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Review Failed to Delete";
        header('Location:index.php');
    }
}
