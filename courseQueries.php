<?php
require_once 'general_functions.php';
set_session();

// display courses by category
function extr_by_category($category){
    try {
        $dbConn = getConnection();

        $coursesQuery = "SELECT *
                        FROM courses
                        WHERE cat_id = :catID
                        ORDER BY rating_avg DESC";
        $query = $dbConn->prepare($coursesQuery);
        $query->execute(array(':catID' => $category));

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to extract the courses from the database";
        exceptionHandler($e, $ermessage);
    }
}

// extract category name
function category_name($category){
    try {
        $dbConn = getConnection();

        $coursesQuery = "SELECT cat_name, cat_image
                        FROM categories
                        WHERE cat_id = :catID";
        $query = $dbConn->prepare($coursesQuery);
        $query->execute(array(':catID' => $category));

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to extract category name from the database";
        exceptionHandler($e, $ermessage);
    }
}

// display all courses
function extr_all_courses(){
    try {
        $dbConn = getConnection();

        $coursesQuery = "SELECT *
                        FROM courses
                        ORDER BY rating_avg DESC";
        $query = $dbConn->query($coursesQuery);

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to extract the courses from the database";
        exceptionHandler($e, $ermessage);
    }
}
// function for extracting course description for selected course
function extr_selected_course($courseID){
    try {
        $dbConn = getConnection();

        $extractCourseQuery = "SELECT * 
                                FROM courses
                                INNER JOIN categories
                                ON courses.cat_id = categories.cat_id
                                WHERE course_id = :id";
        $query = $dbConn->prepare($extractCourseQuery);
        $query->execute(array(':id' => $courseID));

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to extract the course description from the database";
        exceptionHandler($e, $ermessage);
    }
}
// function for extracting syllabus for the selected course
function extr_syllabus($courseID){
    try {
        $dbConn = getConnection();

        $extractCourseQuery = "SELECT *
                                FROM course_syllabus
                                WHERE course_id = :id
                                ORDER BY mod_order ASC";
        $query = $dbConn->prepare($extractCourseQuery);
        $query->execute(array(':id' => $courseID));

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to extract syllabus from the database";
        exceptionHandler($e, $ermessage);
    }
}

// display featured courses
function extr_top_courses(){

    try {
        $dbConn = getConnection();

        $topCoursesQuery = "SELECT *
                        FROM courses
                        ORDER BY rating_avg DESC, review_count DESC"; // oder by the highest average rating and review count (the most popular and highly rated)
        $query = $dbConn->query($topCoursesQuery);

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to extract top courses from the database";
        exceptionHandler($e, $ermessage);
    }
}

function extr_lesson($courseID, $modOrder, $lessonOrder){
    try {
        $dbConn = getConnection();

        $progressQuery = "SELECT *
                        FROM lessons
                        WHERE course_id = :cID AND mod_order = :mID AND lesson_order = :lID";
        $query = $dbConn->prepare($progressQuery);
        $query->execute(array(':cID' => $courseID,':mID'=>$modOrder,':lID' => $lessonOrder));

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to extract the lesson from the database";
        exceptionHandler($e, $ermessage);
    }
}

function get_progress($userID, $courseID){
    try {
        $dbConn = getConnection();

        $progressQuery = "SELECT *
                        FROM user_progress
                        WHERE prog_user_id = :uID AND prog_course_id = :cID";
        $query = $dbConn->prepare($progressQuery);
        $query->execute(array(':uID'=>$userID,':cID' => $courseID));

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to extract user's progress from the database";
        exceptionHandler($e, $ermessage);
    }
}

?>





