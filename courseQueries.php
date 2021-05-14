<?php
require_once 'general_functions.php';
set_session();

// fetch and return the course information
function fetch($query){
    while ($course = $query->fetchObject()) {
        $courseInf['image'] = $course->course_image;
        $courseInf['title'] = $course->course_title;
        $courseInf['desc'] = $course->course_brief_desc;
        $courseInf['id'] = $course->course_id;

        // display courses
        return array($courseInf);
    }
}

// if category is set, display courses by category
if(isset($_GET['cat'])) {
    $category = $_GET['cat'];

    try {
        $dbConn = getConnection();

        $coursesQuery = "SELECT course_id, course_title, course_brief_desc, course_image, rating_avg
                        FROM courses
                        WHERE cat_id = :catID
                        ORDER BY rating_avg DESC";
        $query = $dbConn->prepare($coursesQuery);
        $query->execute(array(':catID' => $category));

        fetch($query);

    } catch (Exception $e) {
        $ermessage = "Failed to extract the courses from the database";
        exceptionHandler($e, $ermessage);
    }
}
// if category is not set, display all courses
else{
    try {
        $dbConn = getConnection();

        $coursesQuery = "SELECT course_id, course_title, course_brief_desc, course_image, rating_avg
                        FROM courses
                        ORDER BY rating_avg DESC";
        $query = $dbConn->query($coursesQuery);

        fetch($query);

    } catch (Exception $e) {
        $ermessage = "Failed to extract the courses from the database";
        exceptionHandler($e, $ermessage);
    }
}
// function for extracting course description for selected course
function extr_selected_course($courseID){
    try {
        $dbConn = getConnection();

        $extractCourseQuery = "SELECT course_title, cat_image, course_desc, course_price, course_image, duration, difficulty 
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

        $extractCourseQuery = "SELECT mod_order, mod_title, mod_duration, brief_desc, mod_desc, mod_image
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
?>


