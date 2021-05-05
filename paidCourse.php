<?php
require_once 'general_functions.php';
set_session();


if (isset($_GET['payment']) && isset($_GET['courseID'])) {

    $courseID = filter_var($_GET['courseID'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    // if payment was successfully made, get user id and add the course to the active_courses table
    if ($_GET['payment'] == true) {

        $userID = $_COOKIE['logon_status'];

        try {
            $dbConnection = getConnection();

            $courseQuery = "INSERT INTO active_courses (course_user_id, course_id)
                        VALUES (':cID', ':uID')";
            $query = $dbConnection->prepare($courseQuery);
            $query->execute(array(':cID' => $courseID, ':uID' => $userID));

            header("Location: #"); // to the course

        } catch (Exception $e) {
            $m = "Failed to add new course to the active courses table";
            exceptionHandler($e, $m);
        }

    }
    // if payment did not go through (if payment variable is set to false)
    else header("Location: #"); // to the course description page (use the course id to redirect to the page)
}
else header("Location: #"); // homepage
