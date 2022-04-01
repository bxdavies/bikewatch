<?php
include("../../functions/database.php"); // This load the database the vairable you will neeed is $DBConnection

$crimeLocations = array();

$crimeLocationsDB = $DBConnection->prepare("SELECT `latitude`, `longitude` FROM `crime`");
$crimeLocationsDB->execute();
$crimeLocationsDBResults = $crimeLocationsDB->get_result();

while($crimeLocation = $crimeLocationsDBResults->fetch_assoc()) {
    $loctaion = array(
        'latitude' => $crimeLocation['latitude'],
        'longitude' => $crimeLocation['longitude'],
    );
    array_push($crimeLocations, $loctaion);
}

echo json_encode($crimeLocations);
