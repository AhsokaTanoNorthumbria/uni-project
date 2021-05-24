<?php

// SET SESSION FUNCTION
function set_session(){
    $fullPath = __DIR__;
    $pathArray = explode('/', $fullPath);
    $inDir = "/$pathArray[1]/$pathArray[2]/sessionData/BrainUp";
    if(!is_dir($inDir)){
        mkdir($inDir, 0777, true);
    }

    ini_set("session.save_path", "$inDir");
    if(!isset($_SESSION)) session_start();

}

function set_cookie($user){
    setcookie('logon_status', $user['id'], time() + (86400 * 14), "/"); //set the cookie, which would expire in 2 weeks
    setcookie('hash', $user['hash'], time() + (86400 * 14), "/"); //set the cookie, which would expire in 2 weeks (for user ID hash)
    setcookie('user-name', $user['firstname'], time() + (86400 * 14), "/"); // cookie for showing the name of the user on the dashboard
}


function logout(){
    setcookie('logon_status', NULL, time() - 1, "/");
    setcookie('hash', NULL, time() - 1, "/");
    setcookie('user-name', NULL, time() - 1, "/");
    header("Location: home.php"); // change # to the homepage
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

//logout
if(isset($_GET['logout'])){
    logout();
}

// check if user has an active course with a gived id
function check_course($courseID){
    $active = false;
    if(!isset($_COOKIE['logon_status'])){
        $active = false;
    }
    else {
        $userID = $_COOKIE['logon_status'];
        try{
            $dbConn = getConnection();

            $extractCourseQuery = "SELECT course_id 
                                FROM active_courses
                                WHERE course_user_id = :uid AND course_id = :cid";
            $query = $dbConn->prepare($extractCourseQuery);
            $query->execute(array(':cid' => $courseID, ':uid' => $userID));

            if(!empty($query->fetchObject())){
                $active = true;
            }
            else $active = false;

        } catch (Exception $e) {
            $ermessage = "Failed to extract user's active courses from the database";
            exceptionHandler($e, $ermessage);
        }
    }
    return $active;
}

?>
