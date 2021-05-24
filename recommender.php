<?php
require_once 'courseQueries.php';
require_once 'recommender_functions.php';

$userID = $_COOKIE['logon_status'];

// LOAD ALL THE RESULTS FROM THE DATABASE QUERIES
    $activeTable = check_active($userID);
    $activeCourses = $activeTable->fetchObject();
    $recTable = check_rec($userID);
    $recCourses = $recTable->fetchObject();
    $ratedTable = check_rated($userID);
    $ratedCourses = $ratedTable->fetchObject();
    $notesTable = check_notes($userID);
    $notes = $notesTable->fetchObject();
    $tasksTable = check_tasks($userID);
    $tasks = $tasksTable->fetchObject();
    $recommendation = array();

// RECOMMENDATIONS TABLE IS NOT EMPTY
    if ($recCourses) {
        // IF ACTIVE COURSES TABLE IS NOT EMPTY
        if ($activeCourses) {
            // IF USER HAS RATED THE COURSES (IF USER'S ID IS PRESENT IN REVIEWS TABLE)
            // CALCULATE AND ADD COURSE ID TO THE ARRAY
            if ($ratedCourses) {
                // GET THE ONES THAT ARE 4-5 STAR REVIEWS
                $ratedArray = calculate($ratedTable, $recommendation);
                $activeAndRatedArray = calculate($activeTable, $recommendation);

            }
        }
        // IF ACTIVE COURSES ARE EMPTY RECOMMEND FROM RECOMMENDATIONS (QUIZ)
        // ADD COURSE ID TO THE ARRAY
        else {
            $courseID1 = $recCourses->rec_course_id1;
            $courseID2 = $recCourses->rec_course_id2;
            $courseID3 = $recCourses->rec_course_id3;
            array_push($recommendation, $courseID1, $courseID2, $courseID3);
        }
    }
// IF RECOMMENDATIONS ARE EMPTY BUT ACTIVE COURSES ARE NOT EMPTY
// CALCULATE ACCORDING TO THE ACTIVE COURSES AND ADD COURSE ID TO THE ARRAY
    else {
        if ($activeCourses) {
            $recommendation = calculate($activeTable, $recommendation);
        }
    }
// IF NOTES OR TASKS ARE NOT EMPTY
    if ($notes or $tasks) {
        // IF IT'S NOTES AND THERE IS MORE/IS SIX OF THEM, RECOMMEND ONE FROM "MTVN" CATEGORY (HIGHEST RATING)
        // ADD COURSE ID TO THE ARRAY
        $i = 0;
        if (!empty($notes)) {
            while ($notes = $notesTable->fetchObject()) {
                $i++;
            }
            if ($i >= 6) {
                $catID = 'MTVN';
                $coursesTableByCat = extr_by_category($catID);
                $fetch = $coursesTableByCat->fetchObject();
                $courseID = $fetch->course_id;
                array_push($recommendation, $courseID);
            }
        }
        // IF IT'S TASKS, RECOMMEND ONE FROM "PRFM" OR "TMNG" CATEGORY (DEPENDING WHICH HASH HIGHEST RATING)
        // ADD COURSE ID TO THE ARRAY
        if (!empty($tasks)) {
            while ($tasks = $tasksTable->fetchObject()) {
                $i++;
            }
            if ($tasks >= 6) {
                $catID = 'PRFM';
                $coursesTableByCat = extr_by_category($catID);
                $fetch = $coursesTableByCat->fetchObject();
                $courseID = $fetch->course_id;
                array_push($recommendation, $courseID);
                $catID = 'TMNG';
                $coursesTableByCat = extr_by_category($catID);
                $fetch = $coursesTableByCat->fetchObject();
                $courseID = $fetch->course_id;
                array_push($recommendation, $courseID);
            }
        }
    }
// IF RECOMMENDATIONS, ACTIVE COURSES NOTES AND TASKS ARE EMPTY DISPLAY FEATURED COURSES
    if ((empty($recCourses)) and (empty($activeCourses)) and (empty($notes)) and (empty($tasks))) {
        $featured = extr_top_courses();
        $i = 0;
        while ($i <= 3) {
            $fetch = $featured->fetchObject();
            $courseID = $fetch->course_id;
            array_push($recommendation, $courseID);
            $i++;
        }
    }


// CHECK IF COURSES ARE IN THE ACTIVE COURSES TABLE BEFORE RECOMMENDING
// IF THEY ARE, REMOVE FROM THE ARRAY
// CHECK IF THERE IS ENOUGH COURSES (3) TO RECOMMEND
// IF NOT, ADD SOME FROM FEATURED (UNTIL THERE IS 3)

// CHECK IF COURSES REPEAT

// SHUFFLE THE ARRAY
// LEAVE ONLY THREE COURSES IN THE ARRAY
// SET courseID['rec1'], courseID['rec2'], AND courseID['rec3']
// CHECK IF USER IS PRESENT IN RECOMMENDATIONS TABLE
// IF YES ---- UPDATE THE RECOMMENDATIONS TABLE
// IF NO ---- ADD TO THE RECOMMENDATIONS TABLE

// EXTRACT FROM RECOMMENDATIONS TABLE
// ECHO

    $i = 0;
    $arrayLength = count($recommendation);
    while ($i < $arrayLength) {
        $recCourse = $recommendation[$i];
        $result = check_active_course($userID, $recCourse);
        if ($result) {
            unset($recommendation[$i]);
        }

    }
    if ((count($recommendation)) <= 3) {
        $featured = extr_top_courses();
        while ((count($recommendation)) < 3) {
            $fetch = $featured->fetchObject();
            $courseID = $fetch->course_id;
            array_push($recommendation, $courseID);
        }
    }

    shuffle($recommendation);

    if ($arrayLength >= 3) {
        while (((count($recommendation)) > 3)) {
            unset($recommendation[$i]);
        }
    }
    $courseID1 = $recommendation[0];
    $courseID2 = $recommendation[1];
    $courseID3 = $recommendation[2];


    if ($recCourses) {
        update_rec($userID, $courseID1, $courseID2, $courseID3);
    } else {
        add_rec($userID, $courseID1, $courseID2, $courseID3);
    }

    $recQuery = check_rec($userID);
    $fetch = $recQuery->fetchObject();

    $recID1 = $fetch->rec_course_id1;
    $recID2 = $fetch->rec_course_id2;
    $recID3 = $fetch->rec_course_id3;

    $getCourse1 = get_all($recID1);
    $getCourse2 = get_all($recID2);
    $getCourse3 = get_all($recID3);

    $fetch1 = $getCourse1->fetchObject();
    $fetch2 = $getCourse2->fetchObject();
    $fetch3 = $getCourse3->fetchObject();


echo "
                    <div class='col-sm-12 col-md-6 col-lg-4 px-3 mb-4 d-flex justify-content-center'>
                        <div class='col-11 d-flex justify-content-center'>
                            <div class='allCourse card'>
                                <a href='coursePage.php?courseID={$fetch1->course_id}'>
                                    <img src='{$fetch1->course_image_laptop}' class='img-fluid' alt='course image'/>
                                    <h4 class='ms-3 my-4'><b>{$fetch1->course_title}</b></h4>
                                    <p class='mx-3'>{$fetch1->course_brief_desc}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class='col-sm-12 col-md-6 col-lg-4 px-3 mb-4 d-flex justify-content-center'>
                        <div class='col-11 d-flex justify-content-center'>
                            <div class='allCourse card'>
                                <a href='coursePage.php?courseID={$fetch2->course_id}'>
                                    <img src='{$fetch2->course_image_laptop}' class='img-fluid' alt='course image'/>
                                    <h4 class='ms-3 my-4'><b>{$fetch2->course_title}</b></h4>
                                    <p class='mx-3'>{$fetch2->course_brief_desc}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class='col-sm-12 col-md-6 col-lg-4 px-3 mb-4 d-flex justify-content-center'>
                        <div class='col-11 d-flex justify-content-center'>
                            <div class='allCourse card'>
                                <a href='coursePage.php?courseID={$fetch3->course_id}'>
                                    <img src='{$fetch3->course_image_laptop}' class='img-fluid' alt='course image'/>
                                    <h4 class='ms-3 my-4'><b>{$fetch3->course_title}</b></h4>
                                    <p class='mx-3'>{$fetch3->course_brief_desc}</p>
                                </a>
                            </div>
                        </div>
                    </div>";

