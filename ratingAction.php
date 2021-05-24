<?php
require_once 'general_functions.php';
require_once 'courseQueries.php';

$courseID = $_POST['courseID'];
$userID = $_COOKIE['logon_status'];
$rating = $_POST['rating'];


try {
    $dbConn = getConnection();

    $reviewQuery = "INSERT INTO course_reviews(course_id, rev_user_id, review)
                        VALUES (:cid, :uid, :rev)";
    $query = $dbConn->prepare($reviewQuery);
    $query->execute(array(':cid' => $courseID, ':uid' => $userID, ':rev' => $rating));

    $courseTable = extr_selected_course($courseID);
    $fetchCourse = $courseTable->fetchObject();
    $ratingAvg = $fetchCourse->rating_avg;
    $reviewCount = $fetchCourse->review_count;

    $newRevCount = $reviewCount+1;
    $newAvg = ($ratingAvg*$reviewCount+$rating)/$newRevCount;


    $updateReviewQuery = "UPDATE courses
                            SET rating_avg = $newAvg, review_count = $newRevCount ";
    $query = $dbConn->query($updateReviewQuery);

    header("Location: dashboard.php");

} catch (Exception $e) {
    $ermessage = "Failed to add a new review for the course";
    exceptionHandler($e, $ermessage);
}

