<?php

/**
 * sendEmail
 *
 * @param  string $to
 * @param  string $subject
 * @param  string $message
 * @return void
 */
function sendEmail(string $to, string $subject, string $message){

    // Start subject with Gloucestershire Constabulary BikeWatch
    $subject = "Gloucestershire Constabulary BikeWatch - ". $subject;

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Set from header
    $headers .= 'From: bikewatch@s4101563-ct4009.uogs.co.uk' . "\r\n";

    // Use the PHP mail function
    mail($to, $subject, $message, $headers);
}
