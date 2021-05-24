<?php
require_once 'general_functions.php';

function get_all($courseID){
    try {
        $dbConn = getConnection();

        $activeQuery = "SELECT *
                    FROM courses
                    WHERE course_id = :cid";                       // GET ACTIVE COURSES TABLE
        $query = $dbConn->prepare($activeQuery);
        $query->execute(array(':cid' => $courseID));

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to access courses table";
        exceptionHandler($e, $ermessage);
    }
}

function check_active($userID){
    try {
        $dbConn = getConnection();

        $activeQuery = "SELECT *
                    FROM active_courses
                    WHERE course_user_id = :uid";                       // GET ACTIVE COURSES TABLE
        $query = $dbConn->prepare($activeQuery);
        $query->execute(array(':uid' => $userID));

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to access active courses table";
        exceptionHandler($e, $ermessage);
    }
}

function check_rec($userID){
    try {
        $dbConn = getConnection();

        $rcmndQuery = "SELECT *
                    FROM user_rec_course
                    WHERE rec_user_id = :uid";                       // GET RECOMMENDATIONS TABLE
        $query = $dbConn->prepare($rcmndQuery);
        $query->execute(array(':uid' => $userID));

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to access recommended courses table";
        exceptionHandler($e, $ermessage);
    }
}


function check_active_course($userID, $courseID){
    try {
        $dbConn = getConnection();

        $rcmndQuery = "SELECT *
                    FROM active_courses
                    WHERE course_user_id = :uid AND course_id = :cid";                       // CHECK IF COURSE IS ALREADY ACTIVE
        $query = $dbConn->prepare($rcmndQuery);
        $query->execute(array(':uid' => $userID, ':cid' => $courseID));

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to access active courses table";
        exceptionHandler($e, $ermessage);
    }
}


function check_rated($userID){
    try {
        $dbConn = getConnection();

        $reviewQuery = "SELECT *
                    FROM course_reviews
                    WHERE rev_user_id = :uid
                    ORDER BY review DESC";                       // GET REVIEWS TABLE
        $query = $dbConn->prepare($reviewQuery);
        $query->execute(array(':uid' => $userID));

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to access course reviews table";
        exceptionHandler($e, $ermessage);
    }
}


function check_notes($userID){
    try {
        $dbConn = getConnection();

        $notesQuery = "SELECT *
                    FROM notes
                    WHERE n_user_id = :uid";                       // GET NOTES TABLE
        $query = $dbConn->prepare($notesQuery);
        $query->execute(array(':uid' => $userID));

        return $query; // int

    } catch (Exception $e) {
        $ermessage = "Failed to access notes table";
        exceptionHandler($e, $ermessage);
    }
}


function check_tasks($userID){
    try {
        $dbConn = getConnection();

        $tasksQuery = "SELECT *
                    FROM planner
                    WHERE pl_user_id = :uid";                       // GET TASKS TABLE
        $query = $dbConn->prepare($tasksQuery);
        $query->execute(array(':uid' => $userID));

        return $query; //int

    } catch (Exception $e) {
        $ermessage = "Failed to access planner table";
        exceptionHandler($e, $ermessage);
    }
}


function update_rec($userID, $courseID1, $courseID2, $courseID3){
    try {
        $dbConn = getConnection();

        $tasksQuery = "UPDATE user_rec_course
                    SET rec_course_id1 = :rec1, rec_course_id2 = :rec2, rec_course_id3 = :rec3
                    WHERE rec_user_id = :uid";                       // ADD COURSE TO RECOMMENDATIONS TABLE
        $query = $dbConn->prepare($tasksQuery);
        $query->execute(array(':uid' => $userID, ':rec1' => $courseID1, ':rec2' => $courseID2, ':rec3' => $courseID3));

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to add course to the recommended courses table";
        exceptionHandler($e, $ermessage);
    }
}

function add_rec($userID, $courseID1, $courseID2, $courseID3){
    try {
        $dbConn = getConnection();

        $tasksQuery = "INSERT INTO user_rec_course(rec_user_id, rec_course_id1, rec_course_id2, rec_course_id3)
                        VALUES (:uid, :rec1, :rec2, :rec3)";                       // ADD COURSE TO RECOMMENDATIONS TABLE
        $query = $dbConn->prepare($tasksQuery);
        $query->execute(array(':uid' => $userID, ':rec1' => $courseID1, ':rec2' => $courseID2, ':rec3' => $courseID3));

        return $query;

    } catch (Exception $e) {
        $ermessage = "Failed to add course to the recommended courses table";
        exceptionHandler($e, $ermessage);
    }
}

function calculate($table, $recommendation){
    $array = array();
    while($courses = $table->fetchObject()){
        $courseID = $courses -> course_id; // get course id of the rated course
        $catTable = get_all($courseID); // get cat name of that course
        $catID = $catTable->fetchObject();
        array_push($array, $catID);
    }
    $category = category_calculation($array);
    $catTable = extr_by_category($category);

    $i = 0;
    while($i<=2){
        $getCourses = $catTable->fetchObject();
        $courseID = $getCourses->course_id;
        array_push($recommendation, $courseID);
        $i++;
    }

    return array($recommendation);
}

function category_calculation($array){
    $i=0;
    $category = '';
    $c1 = 0;
    $c2 = 0;
    $c3 = 0;
    $c4 = 0;
    $c5 = 0;
    $c6 = 0;
    $c7 = 0;
    $c8 = 0;
    while((count($array))<$i){
        $cat = $array[$i];
        if($cat === "CWOT"){
            $c1++;
        }
        if($cat === "GRTH"){
            $c2++;
        }
        if($cat === "IDGN"){
            $c3++;
        }
        if($cat === "MTRC"){
            $c4++;
        }
        if($cat === "MTVN"){
            $c5++;
        }
        if($cat === "PRFM"){
            $c6++;
        }
        if($cat === "RDTQ"){
            $c7++;
        }
        if($cat === "TMNG"){
            $c8++;
        }
    }
    if((max($c1, $c2, $c3, $c4, $c5, $c6))==$c1){
        $category = "CWOT";
    }
    if((max($c1, $c2, $c3, $c4, $c5, $c6))==$c2){
        $category = "GRTH";
    }
    if((max($c1, $c2, $c3, $c4, $c5, $c6))==$c3){
        $category = "IDGN";
    }
    if((max($c1, $c2, $c3, $c4, $c5, $c6))==$c4){
        $category = "MTRC";
    }
    if((max($c1, $c2, $c3, $c4, $c5, $c6))==$c5){
        $category = "MTVN";
    }
    if((max($c1, $c2, $c3, $c4, $c5, $c6))==$c6){
        $category = "PRFM";
    }
    if((max($c1, $c2, $c3, $c4, $c5, $c6))==$c7){
        $category = "RDTQ";
    }
    if((max($c1, $c2, $c3, $c4, $c5, $c6))==$c8){
        $category = "TMNG";
    }

    return $category;
}