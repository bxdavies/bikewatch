<?php

// Parse ini file
$ini = parse_ini_file(__DIR__ . '/../../app.ini');

// Create mysqli object from ini variables
$DBConnection = new mysqli($ini['db_host'], $ini['db_user'], $ini['db_password'], $ini['db_database']);

// Output any connection errors
if ($DBConnection->connection_error){
    echo $DBConnection->onnection_error;
}

?>