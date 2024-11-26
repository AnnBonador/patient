<?php
include('authentication.php');
include('../admin/config/dbconn.php');
include('payment_config.php');


date_default_timezone_set("Asia/Manila");

if (isset($_POST['insertdata'])) {
    $services = '';
    $patient_name = $_SESSION['auth_user']['user_fname'];
    $patient_id = $_POST['userid'];
    $doctor_id = $_POST['preferredDentist'];
    
    $scheddate = $_POST['scheddate'];
    $date = DateTime::createFromFormat('m/d/Y', $scheddate);
    $schedule = $date->format('Y-m-d');

    $selectedTime = $_POST['selected_time_slot'];

    $service = $_POST['service'];
    foreach ($service as $selectedService) {
        $services .= $selectedService . ",";
    }
    $preferredServices = rtrim($services, ", ");
    $status = 'Pending';
    $schedtype = "Online Schedule";
    $subject = 'Request An Appointment';
    $date_submitted = date('Y-m-d H:i:s');

    $sql = "SELECT id FROM schedule WHERE doc_id='$doctor_id'";
    $query_run = mysqli_query($conn, $sql);
    $schedule_id = mysqli_fetch_assoc($query_run)['id'];

    $sql = "SELECT * FROM health_declaration WHERE patient_id = '$patient_id'";
    $query_run = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query_run) > 0) {
        $sql = "DELETE FROM health_declaration WHERE patient_id='$patient_id'";
        $query_run = mysqli_query($conn, $sql);
        foreach ($_POST as $key => $val) {
            if (substr($key, 0, 3) == 'ans') {
                $key = substr($key, 4);
                $sql2 = "INSERT INTO health_declaration (patient_id,question_id,answer) VALUES ('$patient_id','$key','$val') ";
                $query_run1 = mysqli_query($conn, $sql2);
            }
        }
    } else {
        foreach ($_POST as $key => $val) {
            if (substr($key, 0, 3) == 'ans') {
                $key = substr($key, 4);
                $sql2 = "INSERT INTO health_declaration (patient_id,question_id,answer) VALUES ('$patient_id','$key','$val') ";
                $query_run1 = mysqli_query($conn, $sql2);
            }
        }
    }

    $sql = "INSERT INTO tblappointment (patient_id,patient_name,doc_id,schedule,sched_id,starttime,reason,schedtype,status,payment_option,created_at)
        VALUES ('$patient_id','$patient_name','$doctor_id','$schedule','$schedule_id','$selectedTime','$preferredServices','$schedtype','$status','paypal','$date_submitted')";
    $query_run = mysqli_query($conn, $sql);
    $last_id = mysqli_insert_id($conn);

    if ($query_run) {
        $data = array(
            'cmd'            => '_xclick',
            'amount'        => $fee,
            'item_number' => $_SESSION['auth_user']['user_id'],
            'item_name' => 'Appointment Fee',
            'business'         => $paypal_email,
            'cancel_return'    => $CANCEL_URL,
            'notify_url'    => $NOTIFY_URL,
            'currency_code'    => 'PHP',
            'custom' => $last_id,
            'return'        => $RETURN_URL
        );
        header('location:' . $paypal_url . '?' . http_build_query($data));
    } else {
        $_SESSION['error'] = "Appointment Submission Failed";
        header('Location: index.php');
    }

    $sql = "INSERT INTO notification (patient_id,doc_id,subject,created_at) VALUES ('$patient_id','$doctor_id','$subject','$date_submitted')";
    $query_run = mysqli_query($conn, $sql);
}

if (isset($_POST['cancel-appointment'])) {
    $id = $_POST['app_id'];
    $sql = "UPDATE tblappointment SET status='Cancelled' WHERE id='$id'";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Appointment Cancelled Successfully";
        header('Location: index.php');
    } else {
        $_SESSION['error'] = "Appointment Failed to Cancelled";
        header('Location: index.php');
    }
}

if (isset($_GET['dentist'])) {
    $doctor_id = $_GET['doctor_id'];

    $sql = "SELECT * FROM schedule WHERE doc_id = $doctor_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $schedule = $result->fetch_assoc();
        $doctor_schedule = [
            'available_days' => json_decode($schedule['day']),
        ];

        header('Content-Type: application/json');
        echo json_encode($doctor_schedule);
    } else {
        echo json_encode(['error' => 'Schedule not found for the selected doctor.']);
    }
}

if (isset($_GET['timeslots'])) {
    $doctor_id = $_GET['doctor_id'];

    $date = $_GET['date'];
    $dateTime = DateTime::createFromFormat('m/d/Y', $date);
    $selected_date = $dateTime->format('Y-m-d');

    // Fetch the doctor's schedule from the database
    $sql = "SELECT * FROM schedule WHERE doc_id = $doctor_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch schedule data
        $schedule = $result->fetch_assoc();
        $doctor_schedule = [
            'doctor_id' => $schedule['doc_id'],
            'doctor_name' => $schedule['doc_name'],
            'available_days' => json_decode($schedule['day']),
            'start_time' => $schedule['starttime'],
            'end_time' => $schedule['endtime'],
            'duration' => $schedule['duration']
        ];

        // Fetch appointments for the selected date
        $sql_appointments = "SELECT starttime FROM tblappointment WHERE doc_id = $doctor_id AND schedule = '$selected_date'";
        $appointments_result = $conn->query($sql_appointments);
        $booked_slots = [];
        while ($appointment = $appointments_result->fetch_assoc()) {
            $booked_slots[] = $appointment['starttime'];
        }

        // Generate available time slots
        $time_slots = generateTimeSlots($doctor_schedule['start_time'], $doctor_schedule['end_time'], $doctor_schedule['duration']);
        $available_time_slots = array_diff($time_slots, $booked_slots);

        // Return schedule data and available time slots as JSON
        header('Content-Type: application/json');
        echo json_encode([
            'available_time_slots' => array_values($available_time_slots)
        ]);
    } else {
        echo json_encode(['error' => 'Schedule not found for the selected doctor.']);
    }
}

function generateTimeSlots($start_time, $end_time, $duration)
{
    // Convert start and end times to DateTime objects
    $start = new DateTime($start_time);
    $end = new DateTime($end_time);

    // Initialize an empty array to hold the time slots
    $time_slots = [];

    // Loop through the time period and generate slots based on duration
    while ($start < $end) {
        // Format the start time as a string (e.g., "9:00 AM")
        $time_slots[] = $start->format('g:i A');

        // Add the duration to the current time slot
        $start->modify("+$duration minutes");
    }

    return $time_slots;
}