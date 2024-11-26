<?php
include('../../authentication.php');
include('../../config/dbconn.php');
include('../../superglobal.php');

date_default_timezone_set("Asia/Manila");

use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Twilio\Exceptions\TwilioException;

require '../../../vendor/autoload.php';
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
function sendEmail($pdf, $patient_name, $patient_lname, $patient_email, $patient_date, $patient_time, $patient_phone, $treatment, $date_submission, $mail_username, $mail_host, $mail_password, $system_name)
{
  $mail = new PHPMailer(true);
  // $mail->SMTPDebug=3;
  $mail->isSMTP();
  $mail->Host       = $mail_host;
  $mail->SMTPAuth   = true;
  $mail->Username   = $mail_username;
  $mail->Password   = $mail_password;

  $mail->SMTPSecure = 'tls';
  $mail->Port       = 587;

  $mail->setFrom($mail_username, $system_name);
  $mail->addAddress($patient_email);

  //Recipients
  $mail->addStringAttachment($pdf, " $system_name-$patient_lname.pdf");
  // Content
  $mail->isHTML(true);
  $mail->Subject = 'Set an Appointment | ' . $system_name;
  $email_template =
    '<p>Appointment Submitted on ' . $date_submission . '</p>
                    <p>Appointment Details<br>
                    Name: ' . $patient_name . '<br>
                    Contact Number: ' . $patient_phone . '<br>
                    Email: ' . $patient_email . '<br>
                    Preferred Date: ' . $patient_date . '<br>
                    Time: ' . $patient_time . '</p>
                    <p>Treatment: ' . $treatment . '</p>
                    <p>Print, sign and bring the attached PDF on the date of your appointment. This<br>
                    will serve also as proof of appointment.</p>
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
function cancelledEmail($patient_name, $patient_email, $patient_date, $patient_time, $patient_phone, $treatment, $date_submission, $mail_username, $mail_host, $mail_password, $system_name, $mobile)
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
        <p>We regret to inform you that your scheduled appointment on ' . $patient_date . ' at ' . $patient_time . '<br>
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
  } else {
    echo mysqli_error($conn);
  }
}

if (isset($_POST['update_appointment'])) {

  $services = '';
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
  $subject = 'Confirmed your Appointment';
  $type = '1';
  $cancelled = 'Cancelled your Appointment';

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
      $system_contact = $row['mobile'];
      $system_email = $row['email'];
    }
  }

  $sql = "SELECT a.*, CONCAT(p.fname,' ',p.lname) AS pname,p.lname,p.phone,p.email,a.created_at FROM tblappointment a INNER JOIN tblpatient p ON p.id ='$patient_id' WHERE a.id='$id'";
  $query_run = mysqli_query($conn, $sql);
  if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
      $patient_name = $row['pname'];
      $patient_lname = $row['lname'];
      $date_submission = date('l, F j, Y', strtotime($row['created_at']));
      $patient_email = $row['email'];
      $patient_date = date('l, F j, Y', strtotime($row['schedule']));
      $patient_phone = $row['phone'];
      $patient_time = $s_time;
    }
  }

  if ($query_run) {
    if ($status == 'Confirmed') {
      $text = 'Your appointment has been confirmed. Please try to arrive 10-15 minutes early and don\'t forget to wear your face mask. If you have any queries, or need to reschedule, please call our office at ' . $system_contact . ' or drop us a mail ' . $system_email . '. We look forward to seeing you on ' . $patient_date . ' ' . $patient_time . '. ';
      sendTextMessage($patient_name, $patient_phone, $text);
    } else if ($status == 'Cancelled') {
      $text = 'Your appointment has been cancelled.';
      sendTextMessage($patient_name, $patient_phone, $text);
      cancelledEmail($patient_name, $patient_email, $patient_date, $patient_time, $patient_phone, $treatment, $date_submission, $mail_username, $mail_host, $mail_password, $system_name, $mobile);
    }

    if (isset($send_email)) {
      $mpdf = new \Mpdf\Mpdf();
      $answer = array();
      $qanda = "SELECT h.answer,h.question_id,q.questions from health_declaration h INNER JOIN questionnaires q ON h.question_id = q.id WHERE h.patient_id = '$patient_id'";
      $query_run = mysqli_query($conn, $qanda);
      $data = '
            <html>

            <head>
              <style>
                body {
                  font-size: 12px;
                }
            
                .clearfix {
                  clear: both;
                }
            
                .img {
                  float: left;
                }
              </style>
            </head>
            
            <body>
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-8">
                    <div class="invoice p-3 mb-3" id="prescription">
                        <img src="../../../upload/' . $system_logo . '" height="100" alt="Logo">
                      <br>
                      <table class="table" style="width:100%;">
                        <tr>
                          <td>Name: <b>' . $patient_name . '</b></td>
                          <td>Date Submitted: <b>' . $date_submission . '</b></td>
                        </tr>
                        <tr>
                          <td>Email: <b>' . $patient_email . '</b></td>
                          <td>Contact Number:<b>' . $patient_phone . '</b></td>
                        </tr>
                        <tr>
                          <td>Date of Visit: <b>' . $patient_date . '</b></td>
                          <td>Time of Visit: <b>' . $patient_time . '</b></td>
                        </tr>
                      </table>
                      <p>Treatment: ' . $treatment . '</p>
                      Health Declaration';
      while ($row = mysqli_fetch_array($query_run)) {
        $data .= '<ul>
                        <li>' . $row['questions'] . ' <b>' . $row['answer'] . '</b>
                        <li>
                      </ul>';
      }
      $data .= '
                      <br>
                      <table class="table" style="width:100%;">
                        <tr>
                          <td>Patient\'s or Guardian\'s Full Name:</td>
                          <td>Signature:</td>
                        </tr>
                        <tr>
                          <td>Relationship to Patient:</td>
                          <td>Date Signed:</td>
                        </tr>
                        <tr>
                          <td>Confirmed Date & Time of Visit:</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              </div>
            </body>
            
            </html>                              
            ';

      $mpdf->WriteHtml($data);
      $pdf = $mpdf->output("", "S");
      sendEmail($pdf, $patient_name, $patient_lname, $patient_email, $patient_date, $patient_time, $patient_phone, $treatment, $date_submission, $mail_username, $mail_host, $mail_password, $system_name);
    }
    $_SESSION['success'] = "Online Appointment Request Updated Successfully";
    header('Location:index.php');
  } else {
    $_SESSION['error'] = "Online Appointment Request Failed to Scheduled";
    header('Location:index.php');
  }
}

if (isset($_POST['deletedata'])) {
  $id = $_POST['delete_id'];

  $sql = "DELETE FROM tblappointment WHERE id='$id' ";
  $query_run = mysqli_query($conn, $sql);

  if ($query_run) {
    $_SESSION['success'] = "Online Appointment Request Successfully";
    header('Location:index.php');
  } else {
    $_SESSION['error'] = "Online Appointment Request Failed to Delete";
    header('Location:index.php');
  }
}

if (isset($_GET['health_dec'])) {
  $id = $_GET['user_id'];

  $sql = "SELECT q.questions,h.patient_id,h.question_id,h.answer FROM questionnaires q INNER JOIN health_declaration h ON h.question_id = q.id WHERE h.patient_id='$id' ";
  $query_run = mysqli_query($conn, $sql);

  if (mysqli_num_rows($query_run) > 0) {
    while ($row = mysqli_fetch_array($query_run)) {
      echo '
                    <ul>
                        <li>' . $row['questions'] . ' <b> ' . $row['answer'] . '</b></li>
                    </ul>
                ';
    }
  } else {
    echo $id;
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
