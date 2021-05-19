<?php
require_once 'general_functions.php';
set_session();

// display courses by category
function extr_by_category($category){
    try {
        $dbConn = getConnection();

        $coursesQuery = "SELECT course_id, course_title, course_brief_desc, course_image, rating_avg
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

        $coursesQuery = "SELECT cat_name
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

?>





