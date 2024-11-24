<?php
include('../admin/config/dbconn.php');
// PAYPAL CONFIGURATION
$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

$sql = "SELECT * FROM payment_settings WHERE id=1";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {

    $paypal_email = $row['business_email'];
    $RETURN_URL = $row['success'];
    $CANCEL_URL = $row['cancel'];
    $NOTIFY_URL = $row['ipn'];
    $fee = $row['fee'];
}
$currency = 'PHP';
$local_certificate = FALSE;
$sandbox = TRUE;

if ($sandbox === TRUE) {
    $paypal_url = "https://www.sandbox.paypal.com/mep";
} else {
    $paypal_url = "https://www.sandbox.paypal.com/mep";
}
