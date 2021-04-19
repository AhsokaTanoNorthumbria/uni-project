<?php

// SET SESSION FUNCTION
function set_session(){
    ini_set("session.save_path", "/home/unn_w19022158/sessionData/brainup");
    if(!isset($_SESSION)) session_start();

}

function set_cookie($userID){
    setcookie('logon_status', $userID, time() + (86400 * 14), "/"); //set the cookie, which would expire in 2 weeks
}


function logout(){
    $userID = $_COOKIE['logon_status'];
    setcookie('logon_status', $userID, time() -3600);
    header("Location: #"); // change # to the homepage
}

// DATABASE CONNECTION
function getConnection() {
    try {
        $connection = new
        PDO("mysql:host=localhost; dbname=unn_w19022158",
            "unn_w19022158", "KF5012AhsokaTano");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (Exception $e) {
        $ermessage = "Connection to the database failed";
        exceptionHandler ($e, $ermessage);
    }
}

// EXCEPTIONS LOG
function log_error($e, $ermessage){
    $fileHandle = fopen('error_log_file.log', 'ab'); //open file
    $errorDate = date('D M j G:i:s T Y');
    $line = $e->getLine();
    $file = $e->getFile();
    $errorMessage = "On line $line, in $file ERROR: $ermessage:" . $e->getMessage();
    $toReplace = array("\r\n", "\n", "\r"); //characters to replace
    $replaceWith = ' ';
    $errorMessage = str_replace($toReplace, $replaceWith, $errorMessage);
    fwrite($fileHandle, "$errorDate|$errorMessage".PHP_EOL); //write to and close the file
    fclose($fileHandle);
}

// EXCEPTION HANDLER
function exceptionHandler ($e, $ermessage) {

    echo "<p><strong>A problem has occurred. Please try again later.</strong></p>";
    log_error($e, $ermessage);

}
set_exception_handler('exceptionHandler');

?>