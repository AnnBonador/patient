<?php

    include('../admin/config/dbconn.php');

    $doctor_id = $_POST['doctor_id'];

    $table = 'schedule';
    $primaryKey = 'id';
    
    $columns = array(
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
        array( 'db' => 'starttime',  'dt' => 'starttime' ),
        array( 'db' => 'endtime',   'dt' => 'endtime' ),
        array( 'db' => 'duration',   'dt' => 'duration' ),
        array( 'db' => 'id',   'dt' => 'id' ),
    );
    
    require( '../admin/config/sspconn.php' );
    
    require( 'ssp.class.php' );
    $where = "doc_id ='".$doctor_id."'";
    echo json_encode(
        SSP::complex( $_POST, $sql_details, $table, $primaryKey, $columns, $where)
    );

?>