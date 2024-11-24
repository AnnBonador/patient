<?php

$sname = "localhost"; // Database server name
$uname = "u642540313_dentalclinic"; // Database username
$password = "Bbkoh0810*"; // Database password
$db_name = "u642540313_smiles_db"; // Database name

// Establish database connection
$conn = mysqli_connect($sname, $uname, $password, $db_name);

// Check connection
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>
