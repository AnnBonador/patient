<?php

include('../../config/dbconn.php');

$table = 'schedule';
$primaryKey = 'id';

$columns = array(
    array('db' => 'doc_name', 'dt' => 'doc_name'),
    array('db' => 'day', 'dt' => 'day', 'formatter' => function($day) {
        // Check if the 'day' column contains a JSON-encoded array
        $decoded = json_decode($day, true);
        if (is_array($decoded)) {
            // If it's an array, join it into a comma-separated string
            return implode(", ", $decoded);
        }
        // If not an array, return the original value (it may be a string)
        return $day;
    }),
    array('db' => 'starttime', 'dt' => 'starttime'),
    array('db' => 'endtime', 'dt' => 'endtime'),
    array('db' => 'duration', 'dt' => 'duration'),
    array('db' => 'id', 'dt' => 'id'),
);

require('../../config/sspconn.php');
require('../../ssp.class.php');

// Generate the JSON response for DataTables
echo json_encode(
    SSP::complex($_POST, $sql_details, $table, $primaryKey, $columns)
);
?>
