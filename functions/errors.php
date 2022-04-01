<?php

/**
 * errorHandler
 *
 * @param  string $errorNumber
 * @param  string $errorMessage
 * @return void
 */
function errorHandler(int $errorNumber, string $errorMessage) {

    // Convert error numbers to user error numbers
    switch ($errorNumber) {
        case 1;
            $errorNumber = 256;
            break;

        case 2:
            $errorNumber = 512;
            break;
        
        case 8:
            $errorNumber = 1024;
            break;
    }

    // Log error
    error_log($errorMessage, 0);

    // Trigger error 
    trigger_error($errorMessage, $errorNumber);

}

// Set error handler to errorHandler
set_error_handler('errorHandler');