<?php
require_once 'general_functions.php';
require_once 'recommender_functions.php';
require_once 'courseQueries.php';
set_session();
if(isset($_COOKIE['logon_status'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="icon" href="data/brainup.png">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link href="http://code.jquery.com/jquery-1.8.3.min.js" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
<main>
    <div class="wrapper d-flex justify-content-center mt-5">
        <div class="container">
        <div class="header mb-4">
            <?php
                $name = $_COOKIE['user-name'];
                echo "<h1 class='mb-2 text-center'><b>Welcome, $name</b></h1>";
                ?>
            <p class="fs-3 text-center">Here's your timetable for this week</p>
        </div>
        <div class="row d-flex justify-content-center mb-5">
            <div class="col-12 col-lg-6 mb-3 d-flex justify-content-center">
                <div class="col-11 d-flex align-items-center timetable">
                    <div class="col-3">
                        <p class="fs-4 text-center my-0"><b>MON</b></p>
                        <p class="fs-3 text-center my-0"><b>19</b></p>
                    </div>
                    <div class="col-2">
                        <span class="fs-5 text-center">10:00 AM</span>
                    </div>
                    <div class="col-6">
                        <p class="fs-4 text-center my-0"><b>Time Management</b></p>
                        <p class="fs-4 text-center my-0">Seminar 1</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mb-3 d-flex justify-content-center">
                <div class="col-11 d-flex align-items-center timetable">
                    <div class="col-3">
                        <p class="fs-4 text-center my-0"><b>MON</b></p>
                        <p class="fs-3 text-center my-0"><b>19</b></p>
                    </div>
                    <div class="col-2">
                        <span class="fs-5 text-center">10:00 AM</span>
                    </div>
                    <div class="col-6">
                        <p class="fs-4 text-center my-0"><b>Time Management</b></p>
                        <p class="fs-4 text-center my-0">Seminar 1</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mb-3 d-flex justify-content-center">
                <div class="col-11 d-flex align-items-center timetable">
                    <div class="col-3">
                        <p class="fs-4 text-center my-0"><b>MON</b></p>
                        <p class="fs-3 text-center my-0"><b>19</b></p>
                    </div>
                    <div class="col-2">
                        <span class="fs-5 text-center">10:00 AM</span>
                    </div>
                    <div class="col-6">
                        <p class="fs-4 text-center my-0"><b>Time Management</b></p>
                        <p class="fs-4 text-center my-0">Seminar 1</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mb-3 d-flex justify-content-center">
                <div class="col-11 d-flex align-items-center timetable">
                    <div class="col-3">
                        <p class="fs-4 text-center my-0"><b>MON</b></p>
                        <p class="fs-3 text-center my-0"><b>19</b></p>
                    </div>
                    <div class="col-2">
                        <span class="fs-5 text-center">10:00 AM</span>
                    </div>
                    <div class="col-6">
                        <p class="fs-4 text-center my-0"><b>Time Management</b></p>
                        <p class="fs-4 text-center my-0">Seminar 1</p>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="mb-4 text-center"><b>Your current courses</b></h2>
        <div class="row d-flex justify-content-center mb-5">
            
            
            <?php
            $userID = $_COOKIE['logon_status'];
            // get all active courses
            $activeQuery = check_active($userID);
            while($fetchActive = $activeQuery->fetchObject()){
                $courseID = $fetchActive->course_id;
                // extract all needed information about the course
                $courseTable = extr_selected_course($courseID);
                $fetchCourse = $courseTable->fetchObject();
                // get category image
                $catImageQuery = category_name($fetchCourse->cat_id);
                $fetchCat = $catImageQuery->fetchObject();
                $catImg = $fetchCat->cat_image;
                // get data from the user's progress table for generating urls
                $getProgress = get_progress($userID, $courseID);
                $fetchProgress = $getProgress->fetchObject();
                $lesson = $fetchProgress->prog_lesson_order;
                $module = $fetchProgress->prog_mod_order;

                $previousLesson = $lesson-1;
                $nextLesson = $lesson;
                $urlNext = '';
                $urlPrevious = '';

                // generate the urls
                if($lesson==1){
                    $urlNext = 'lesson.php?courseID='.$courseID.'&modOrder='.$module.'&lessonOrder='.$nextLesson;
                    $urlPrevious = '#';
                }
                if($lesson<3 and $lesson>1){
                    $urlNext = 'lesson.php?courseID='.$courseID.'&modOrder='.$module.'&lessonOrder='.$nextLesson;
                    $urlPrevious = 'lesson.php?courseID='.$courseID.'&modOrder='.$module.'&lessonOrder='.$previousLesson;
                }
                if($lesson==3 and $module < 6) {
                    $nextModule = $module + 1;
                    $urlNext = 'lesson.php?courseID='.$courseID.'&modOrder='.$nextModule.'&lessonOrder=1';
                    $urlPrevious = 'lesson.php?courseID='.$courseID.'&modOrder='.$module.'&lessonOrder='.$previousLesson;

                }
                if($lesson==3 && $module==6){
                    $urlPrevious = 'lesson.php?courseID='.$courseID.'&modOrder='.$module.'&lessonOrder='.$previousLesson;
                    $urlNext = 'courses.php';
                }

                    echo "
                     <div class='col-12 col-xl-6 mb-3 d-flex justify-content-center'>
                <div class='light-blue col-11'>
                    <div class='content-wrapper m-2 d-flex align-items-center flex-column flex-md-row justify-content-evenly'>
                        <div class='col-12 col-md-4'>
                            <div class='d-flex justify-content-center'>
                                <img src='$catImg' alt='course logo' width='100'>
                            </div>
                            <p class='fs-5 text-center'><b>$fetchCourse->course_title</b></p>
                        </div>
                        <div class='col-12 col-md-7'>
                            <a class='btn btn-primary btn-lg my-2' href='$urlNext' role='button' style='width: 100%'>Start Next Lesson</a>
                            <a class='btn btn-primary btn-lg mb-2' href='$urlPrevious' role='button' style='width: 100%'>Preview Previous Lesson</a>
                            <div class='row'>
                                <div class='col-12'>
                                    <button type='button' class='btn btn-success mb-2' style='width: 100%'>Options</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
            }
            ?>
            
            
            
        </div>
        </div>
    </div>
        <div class="blue-back d-flex justify-content-center mt-5">
            <div class="container">
                <h2 class="mb-4 pt-3 text-center"><b>Wanting to start a new course?</b></h2>
                <div class="form-wrapper d-flex justify-content-center mb-3">
                    <div class="col-10 col-lg-6">
                        <form id="search_form" class="d-flex me-auto">
                            <input id="searchInput" class="form-control me-1" type="search" pattern="[a-zd.]{3,}" title="Please enter at least 3 characters with no symbols" placeholder="Search for courses..." aria-label="Search">
                            <button class="btn btn-success" type="submit">Search</button>
                        </form>
                    </div>
                </div>
                <div class="button-wrapper d-flex justify-content-center mb-5">
                    <div class="col-10 col-lg-6">
                        <a class="btn btn-primary" href="#" role="button" style="width: 100%">View All Courses</a>
                    </div>
                </div>
                <h2 class="mb-4 pt-3 text-center"><b>Based on your current courses, you may like...</b></h2> 
                <div class="row mt-3 d-flex justify-content-between mx-2" id="display_recommended_courses">
                    
                    
                   <!---RECOMMENDATIONS--->
                    
                    
                </div>
            </div>
        </div>
    <a onclick="topFunction()" id="return-to-top"><i class="icon-chevron-up"></i></a> <!--Return to top button-->
    </div>
    </div>
</main>
<footer class="mt-5 d-md-flex justify-content-evenly">
    <div class="p-0 copyright d-flex justify-content-center">
        <p class="text center mt-4 fs-6" style="color: white"><b>© BrainUp 2021</b></p>
    </div>
        <div class="p-0 social d-flex justify-content-center">
        <p class="text center mt-1 mt-md-4 fs-6" style="color: white"><b>Find us on social media: </b></p>
        <a href="https://facebook.com" class="ms-2 mt-md-3">
            <img src="data/twitter.png" class="img-fluid" style="width: 30px">
        </a>
        <a href="https://facebook.com" class="ms-2 mt-md-3">
            <img src="data/instagram.png" class="img-fluid" style="width: 30px">
        </a>
        <a href="https://facebook.com" class="ms-2 mt-md-3">
            <img src="data/twitter.png" class="img-fluid" style="width: 30px">
        </a>
    </div>
</footer>
<!--SIDEBAR-->
<div class="sidebar-wrapper border border-end-0 border-4">
    <div class="d-grid">
        <a href="home.html"><img class="pointer task_img mb-5 mx-2" src="data/brainup.png" alt="BrainUp logo" width="50"/></a>
        <a data-bs-toggle="collapse" href="#tasksCollapse" role="button" aria-expanded="false" aria-controls="notesCollapse">
            <img class="pointer task_img mb-4 mx-2" src="data/clipboard.png" alt="Task Planner" width="50"/>   </a>
        <a data-bs-toggle="collapse" href="#notesCollapse" role="button" aria-expanded="false" aria-controls="tasksCollapse">
            <img class="pointer notes_img mb-4 mx-2" src="data/journal-text.svg" alt="Notes" width="48"/>  </a>
        <a href="general_functions.php?logout=true"><img class="pointer logout mt-3 mb-2 mx-2" src="data/logout.png" alt="Logout" width="44" style="cursor: pointer"/></a>
    </div>
</div>

<!-- TODO notes here-->

<div class="collapse notes" id="notesCollapse">
    <div class="card card-body">
        <div class="scrollable">
            <div class="me-2">
                <h4><b>Notepad</b></h4>
                <hr class="solid-header mb-3">
                
                
                <div id="display_notes"></div>
                <!-- DISPLAY NOTES -->
            </div>
        </div>
         <div class="mb-3">
            <input type="text" id="note_title" class="form-control form-control-sm mx-1"  placeholder="Note title">
        </div>
        <div class="mb-3">
            <textarea id="note_text" class="form-control mx-1" rows="1"></textarea>
        </div>
        <div class="d-flex justify-content-center mt-2">
            <button type="button" onclick="add('note')" class="btn btn-outline-info btn-sm"> + Note </button>
        </div>
    </div>
</div>

<!-- TODO DB query for tasks here-->

<div class="collapse tasks" id="tasksCollapse">
    <div class="card card-body">
        <div class="scrollable">
            <div class="me-2">
                <h4><b>Task Planner</b></h4>
                <hr class="solid-header mb-3">
                
                
                <div id="display_tasks"></div>
                    <!-- DISPLAY TASKS -->
            </div>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control form-control-sm mb-2 mx-1" placeholder="New task">
            <input type="text" class="form-control form-control-sm mx-1" placeholder="Task comment">
            <div class="d-flex justify-content-center mt-2">

                <!-- TODO Add PHP script to insert task and refresh tasks-->

                <button type="button" class="btn btn-outline-info btn-sm"> + Task </button>
            </div>
        </div>
    </div>
</div>
<script>
    // Enable popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })
    btn = document.getElementById("return-to-top");
    function topFunction() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }
    window.onscroll = function (){
        if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            btn.style.display = "block";
        } else {
            btn.style.display = "none";
        }
    };
</script>
            <!-- LOAD -->
<script>
    load_notes();
    load_tasks();
    recommend();

    function load_notes(){
        $.ajax({
            url: "notes.php?extract=true",
            method: "GET",
            success: function(data){
                $('#display_notes').html(data);
            }
        })
    }

    function load_tasks(){
        $.ajax({
            url: "tasks.php?extract=true",
            method: "GET",
            success: function(data){
                $('#display_tasks').html(data);
            }
        })
    }
    
    function recommend(){
        $.ajax({
            url: "recommender.php",
            method: "GET",
            success: function(data){
                $('#display_recommended_courses').html(data);
            }
        })
    }
</script>
            <!-- DELETE -->
<script>

    function delete_note(id){
        $.ajax({
            url: "notes.php?delete_note=true&noteID="+id,
            method: "GET",
            success: function(){
                load_notes();
            }

        })
    }

    function delete_task(id){
        $.ajax({
            url: "tasks.php?delete_task=true&taskID="+id,
            method: "GET",
            success: function(){
                load_tasks();
            }

        })
    }

</script>
            <!-- ADD -->
<script>
    function add(obj) {
        if(obj === 'note'){
            let title = $('#note_title').val();
            let text = $('#note_text').val();
            $.ajax({
                url: 'notes.php?add_note=true',
                method: 'POST',
                data: "note_title="+title+"&note_text="+text,
                success: function() {
                    load_notes();
                    document.getElementById('note_title').value = '';
                    document.getElementById('note_text').value = '';
                }
            })
        }
        if(obj === 'task'){
            let title = $('#task_title').val();
            let text = $('#task_text').val();
            $.ajax({
                url: 'tasks.php?add_task=true',
                method: 'POST',
                data: "task_title="+title+"&task_text="+text,
                success: function() {
                    load_tasks();
                    document.getElementById('task_title').value = '';
                    document.getElementById('task_text').value = '';
                }
            })
        }
    }
</script>
</body>
<?php
}
else header("Location: home.html");
?>

