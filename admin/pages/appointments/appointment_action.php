
<?php
include('../../authentication.php');
include('../../config/dbconn.php');
include('../../superglobal.php');

date_default_timezone_set("Asia/Manila");

use Twilio\Rest\Client;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Twilio\Exceptions\TwilioException;

require '../../../vendor/autoload.php';

$current_date = date('Y-m-d H:i:s');
$date_submission = date('l, F j, Y', strtotime($current_date));

function sendTextMessage($patient_name, $patient_phone, $text)
{
    include('../../config/dbconn.php');
    $sql = "SELECT * FROM sms_settings WHERE id='1'";
    $query_run = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
            $sid = $row['sid'];
            $token = $row['token'];
            $sender = $row['sender'];
        }
    }
    $client = new Client($sid, $token);

    try {
        $client->messages->create(
            $patient_phone,
            [
                'from' => $sender,
                'body' => 'Dear ' . $patient_name . ', ' . $text . ''
            ]
        );
    } catch (TwilioException $e) {
        echo $e->getCode();
    }
}
function sendEmail($patient_name, $patient_email, $patient_date, $selectedTime, $patient_phone, $treatment, $date_submission, $mail_username, $mail_host, $mail_password, $system_name)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $mail_host;
    $mail->SMTPAuth   = true;
    $mail->Username   =  $mail_username;
    $mail->Password   =  $mail_password;

    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    //$mail->SMTPDebug = 2;

    $mail->setFrom($mail_username, $system_name);
    $mail->addAddress($patient_email);

    $mail->isHTML(true);
    $mail->Subject = 'Set an Appointment | ' . $system_name;
    $email_template =
        '<p>Appointment Submitted on ' . $date_submission . '</p>
                    <p>Appointment Details<br>
                    Name: ' . $patient_name . '<br>
                    Contact Number: ' . $patient_phone . '<br>
                    Email: ' . $patient_email . '<br>
                    Preferred Date: ' . $patient_date . '<br>
                    Time: ' . $selectedTime . '</p>
                    <p>Treatment: ' . $treatment . '</p>
                    <p>Thank you!<br>
                    ' . $system_name . ' Team</p>';
    $mail->Body = $email_template;

    try {
        $mail->send();
        echo "Message has been sent";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function cancelledEmail($patient_name, $patient_email, $patient_date, $selectedTime, $patient_phone, $treatment, $date_submission, $mail_username, $mail_host, $mail_password, $system_name, $mobile)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $mail_host;
    $mail->SMTPAuth   = true;
    $mail->Username   =  $mail_username;
    $mail->Password   =  $mail_password;

    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    //$mail->SMTPDebug = 2;

    $mail->setFrom($mail_username, $system_name);
    $mail->addAddress($patient_email);

    $mail->isHTML(true);
    $mail->Subject = 'Appointment Cancellation Notice | ' . $system_name;
    $email_template =
        '<p> Dear ' . $patient_name . ',</p>
        <p>We regret to inform you that your scheduled appointment on ' . $patient_date . ' at ' . $selectedTime . '<br>
            has been cancelled. We apologize for any inconvenience this may cause. <br>
            If you have any question regarding the cancellation, please don\'t hesitate to contact us.</p> 
            <p>If you would like to reschedule your appointment, please reply to this email or call us at <br>
            ' . $mobile . ' to arrange a new date and time that works for you.</p>
            <p>Thank you for your understanding.</p>
            <p>Best regards,<br>
            ' . $system_name . '</p>';
    $mail->Body = $email_template;

    try {
        $mail->send();
        echo "Message has been sent";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['insert_appointment'])) {

    $services = '';
    $patient_id = $_POST['select_patient'];
    $doctor_id = $_POST['select_dentist'];

    $scheddate = $_POST['scheddate'];
    $date = DateTime::createFromFormat('m/d/Y', $scheddate);
    $schedule = $date->format('Y-m-d');

    $follow_up = $_POST['follow_up'];

    $selectedTime = $_POST['selected_time_slot'];

    foreach ($_POST['service'] as $selectedService) {
        $services .= $selectedService . ",";
    }
    $treatment = rtrim($services, ", ");
    $status = $_POST['status'];
    $bgcolor = $_POST['color'];
    $schedtype = 'Walk-in Schedule';
    $date_submitted = date('Y-m-d H:i:s');
    $send_email = $_POST['send-email'];

    $sql = "SELECT * FROM tblpatient WHERE id='$patient_id'";
    $query_run = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
            $patient_name = $row['fname'] . " " . $row['lname'];
        }
    }

    $sql = "SELECT id FROM schedule WHERE doc_id='$doctor_id'";
    $query_run = mysqli_query($conn, $sql);
    $schedule_id = mysqli_fetch_assoc($query_run)['id'];

    $sql = "INSERT INTO tblappointment (patient_id,patient_name,doc_id,schedule,starttime,sched_id,reason,schedtype,status,bgcolor,follow_up,created_at)
        VALUES ('$patient_id','$patient_name','$doctor_id','$schedule','$selectedTime','$schedule_id','$treatment','$schedtype','$status','$bgcolor','$follow_up','$date_submitted')";
    $query_run = mysqli_query($conn, $sql);

    $sql = "SELECT * from system_details";
    $query_run = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
            $system_logo = $row['brand'];
            $system_contact = $row['mobile'];
            $system_email = $row['email'];
        }
    }

    $sql = "SELECT a.*, CONCAT(p.fname,' ',p.lname) AS pname,p.phone,p.email,a.created_at FROM tblappointment a INNER JOIN tblpatient p WHERE p.id ='$patient_id' ORDER BY a.id DESC";
    $query_run = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
            $patient_name = $row['pname'];
            $patient_email = $row['email'];
            $patient_date = date('l, F j, Y', strtotime($row['schedule']));
            $patient_phone = $row['phone'];
        }
    }

    if ($query_run) {
        if ($status == 'Confirmed') {
            $text = 'Your appointment has been confirmed. Please try to arrive 10-15 minutes early and don\'t forget to wear your face mask. If you have any queries, or need to reschedule, please call our office at ' . $system_contact . ' or drop us a mail ' . $system_email . '. We look forward to seeing you on ' . $patient_date . ' ' . $selectedTime . '. ';
            sendTextMessage($patient_name, $patient_phone, $text);
        }
        if (isset($_POST['send-email'])) {
            sendEmail($patient_name, $patient_email, $patient_date, $selectedTime, $patient_phone, $treatment, $date_submission, $mail_username, $mail_host, $mail_password, $system_name);
        }

        $_SESSION['success'] = "Appointment Added Successfully";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Appointment Failed to Add";
        header('Location:index.php');
    }
}

if (isset($_POST['checking_editbtn'])) {
    $s_id = $_POST['app_id'];

    $sql = "SELECT * FROM tblappointment WHERE id='$s_id' ";
    $query_run = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
            $sched = DateTime::createFromFormat('Y-m-d', $row['schedule'])->format('m/d/Y');
            $result_array = array(
                'id' => $row['id'],
                'patient_id' => $row['patient_id'],
                'doc_id' => $row['doc_id'],
                'schedule' => $sched,
                'starttime' => $row['starttime'],
                'sched_id' => $row['sched_id'],
                'reason' => $row['reason'],
                'status' => $row['status'],
                'bgcolor' => $row['bgcolor'],
                'follow_up' => $row['follow_up']
            );
        }
        header('Content-type: application/json');
        echo json_encode($result_array);
    }
}

if (isset($_POST['update_appointment'])) {
    $id = $_POST['edit_id'];

    $patient_id = $_POST['select_patient'];
    $doctor_id = $_POST['doc_id'];

    $scheddate = $_POST['scheddate'];
    $date = DateTime::createFromFormat('m/d/Y', $scheddate);
    $schedule = $date->format('Y-m-d');

    $follow_up = isset($_POST['follow_up']) ? 1 : 0;

    $selectedTime = $_POST['selected_time_slot'];

    foreach ($_POST['service'] as $selectedService) {
        $services .= $selectedService . ",";
    }
    $treatment = rtrim($services, ", ");

    $sql = "SELECT id FROM schedule WHERE doc_id='$doctor_id'";
    $query_run = mysqli_query($conn, $sql);
    $schedule_id = mysqli_fetch_assoc($query_run)['id'];

    $status = $_POST['status'];
    $bgcolor = $_POST['color'];
    $send_email = $_POST['send-email'];
    $date_submitted = date('Y-m-d H:i:s');

    $sql = "UPDATE tblappointment set doc_id='$doctor_id',schedule='$schedule',starttime='$selectedTime', reason='$treatment',status='$status',bgcolor='$bgcolor',follow_up='$follow_up' WHERE id='$id' ";
    $query_run = mysqli_query($conn, $sql);

    if ($status == 'Treated') {
        $check_app = mysqli_query($conn, "SELECT appointment_id FROM treatment where appointment_id = '$id' ");
        if (mysqli_num_rows($check_app) > 0) {
        } else {
            $sql = "INSERT INTO treatment (appointment_id,patient_id,doc_id,visit,treatment,created_at) VALUES ('$id','$patient_id','$doctor_id','$schedule','$treatment','$date_submitted')";
            $query_run = mysqli_query($conn, $sql);
        }
    } else {
        $check_app = mysqli_query($conn, "SELECT appointment_id FROM treatment where appointment_id = '$id' ");
        if (mysqli_num_rows($check_app) > 0) {
            $sql = "DELETE FROM treatment WHERE appointment_id = '$id'";
            $query_run = mysqli_query($conn, $sql);
        }
    }


    $sql = "SELECT * from system_details";
    $query_run = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
            $system_logo = $row['brand'];
        }
    }

    $sql = "SELECT a.*, CONCAT(p.fname,' ',p.lname) AS pname,p.phone,p.email,a.created_at,a.starttime FROM tblappointment a INNER JOIN tblpatient p ON p.id ='$patient_id' WHERE a.id='$id'";
    $query_run = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
            $patient_name = $row['pname'];
            $patient_email = $row['email'];
            $patient_date = date('l, F j, Y', strtotime($row['schedule']));
            $patient_phone = $row['phone'];
            $selectedTime = $row['starttime'];
        }
    }



    if ($query_run) {
        if ($status == 'Cancelled') {
            $text = 'Your appointment has been cancelled.';
            sendTextMessage($patient_name, $patient_phone, $text);
            cancelledEmail($patient_name, $patient_email, $patient_date, $selectedTime, $patient_phone, $treatment, $date_submission, $mail_username, $mail_host, $mail_password, $system_name, $mobile);
        }
        if (isset($_POST['send-email'])) {
            sendEmail($patient_name, $patient_email, $patient_date, $selectedTime, $patient_phone, $treatment, $date_submission, $mail_username, $mail_host, $mail_password, $system_name);
        }
        $_SESSION['success'] = "Appointment Updated Successfully";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Appointment Failed to Update";
        header('Location:index.php');
    }
}

if (isset($_POST['deletedata'])) {
    $id = $_POST['delete_id'];

    $sql = "DELETE FROM tblappointment WHERE id='$id' ";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Appointment Deleted Successfully";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Appointment Failed to Delete";
        header('Location:index.php');
    }
}

if (isset($_GET['getDoctors'])) {
    $pat_id = $_GET['getDoctors'];
    $today = date("Y-m-d");

    $data = array();

    if ($pat_id != "") {
        $sql = "SELECT * FROM tbldoctor WHERE status='1'";
        $query_run = mysqli_query($conn, $sql);
        if (mysqli_num_rows($query_run) > 0) {
            foreach ($query_run as $row) {
                $id = $row['id'];
                $doctor_name = $row['name'];

                $data[] = array('id' => $id, 'text' => $doctor_name);
            }
        }
    }

    echo json_encode($data);
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

?>
