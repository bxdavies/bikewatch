<?php
$alerts = array();

/**
 * createAlert
 *
 * @param  string $alertType
 * @param  string $alertText
 * @param  string $redirectURL
 * @return void
 */
function createAlert(string $alertType, string $alertText, string $redirectURL = ""){
    global $alerts;
    $alert = array($alertType, $alertText, $redirectURL);
    array_push($alerts, $alert);
};
?>