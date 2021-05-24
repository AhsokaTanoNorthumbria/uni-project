<?php
require_once 'general_functions.php';
set_session();

$courseID = filter_var($_GET['courseID'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
if (!(empty($courseID))) {

    // if payment was successfully made, get user id and add the course to the active_courses table
    if(!(empty($_COOKIE['logon_status'])))
		{
			//get username hash from the user cookie
			$userCookie = $_COOKIE['hash'];
			$loggedIn = true;
		}
	 // if user not loggged in (if user cookie does not exist)	
	 else header("Location: coursePage.php?courseID=$courseID"); // to the course description page (use the course id to redirect to the page)	
	
	// if payment was successfully made, get user id and add the course to the active_courses table	
	if ($loggedIn && $_GET['payment'] === $userCookie) {

        $userID = $_COOKIE['logon_status'];

        try {
            $dbConnection = getConnection();

		// add new user to the active courses table
            $courseQuery = "INSERT INTO active_courses (course_user_id, course_id)
                        VALUES (:cID, :uID)";
            $query = $dbConnection->prepare($courseQuery);
            $query->execute(array(':cID' => $courseID, ':uID' => $userID));
		
		// add new user to the course progress table
            $courseQuery = "INSERT INTO user_progress (prog_user_id, prog_course_id, prog_mod_order, prog_lesson_order)
                        VALUES (:uID, :cID, :mID, :lID)";
            $query = $dbConnection->prepare($courseQuery);
            $query->execute(array(':uID' => $userID, ':cID' => $courseID, ':mID' => 1, ':lID' => 1));


            header("Location: lesson.php?courseID=$courseID&modOrder=1&lessonOrder=1"); // redirect user to the first lesson of the course

        } catch (Exception $e) {
            $m = "Failed to add new course to the active courses table and new user to the user progress table";
            exceptionHandler($e, $m);
        }

    }
    // if payment did not go through (if payment variable was not the user hash or user was not logged in)
    else header("Location: coursePage.php?courseID='$courseID'"); // to the course description page (use the course id to redirect to the page)
}
else header("Location: home.html"); // if no course ID was passed in the URL, redirect the user to the homepage
