<?php
require_once 'general_functions.php';
require_once 'recommender_functions.php';
require_once 'courseQueries.php';

if(isset($_COOKIE['logon_status']) and isset($_GET['courseID']) and isset($_GET['modOrder']) and isset($_GET['lessonOrder'])){
    $userID = $_COOKIE['logon_status'];
    $courseID = filter_var($_GET['courseID'], FILTER_SANITIZE_NUMBER_INT);
    $module = filter_var($_GET['modOrder'], FILTER_SANITIZE_NUMBER_INT);
    $lesson = filter_var($_GET['lessonOrder'], FILTER_SANITIZE_NUMBER_INT);
    $active = check_active_course($userID, $courseID);
    if($active){
        $getLesson = extr_lesson($courseID,$module, $lesson);
        $fetchLesson = $getLesson->fetchObject();
        $getCourse = extr_selected_course($courseID);
        $fetchCourse = $getCourse->fetchObject();
        $catImageQuery = category_name($fetchCourse->cat_id);
        $fetchImage = $catImageQuery->fetchObject();
        $catImage = $fetchImage->cat_image;
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <head>
            <meta charset="UTF-8">
            <title>Lesson</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
            <link rel="icon" href="data/brainup.png">
            <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
            <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
            <link href="http://code.jquery.com/jquery-1.8.3.min.js" crossorigin="anonymous">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <link rel="stylesheet" href="lesson.css">
        </head>
    </head>
    <body>
    <header class="row header p-4 d-flex justify-content-center align-items-center" style="background: #d9effd">
        <div class="logo col-12 col-xl-6 d-sm-flex">
            <div class="img_wrapper d-flex justify-content-center">
                <?php
                echo "<img class='course_img' src='$catImage'/>";
                ?>

            </div>
            <div class="text_wrapper pt-3">
                <?php
                echo "<h2 class='text-center ms-4'><b>$fetchCourse->course_title</b></h2>";
                ?>

                <?php
                echo "<p class='text-center fs-3 ms-4'>Module $module: Lesson $lesson</p>";
                ?>

            </div>
        </div>
        <div class="col-12 col-md-8 col-xl-4">
            <h4 class="mb-2">54% complete</h4>
            <div class="progress border border-dark border-1" style="height: 30px">
                <!--edit style="width: 54%" aria-valuenow="54" to edit progress -->
                <div class="progress-bar" role="progressbar" style="width: 54%" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="row d-block d-xl-flex">
                <div class="hdr_btn col-8 mt-2">
                    <!--TODO add onclick functionality -->
                    <a class="btn btn-primary" href="" style="width: 100%; height: 100%" role="button">Save current position and return to dashboard</a>
                </div>
                <div class="hdr_btn col-4 mt-2">
                    <!--TODO add onclick functionality -->
                    <a class="btn btn-primary" style="width: 100%; height: 100%" href="dashboard.php" role="button">Return without saving</a>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container-xl d-flex justify-content-between mt-5">
                <div class="lesson_content col-12 col-xl-7 d-flex justify-content-center">
                    <div class="wrapper">
                        <div class="mobile_tasks col-12 mb-2">
                            <?php
                            echo "<h2 class='text-center'><b>Current lesson: </b>Lesson {$fetchLesson->lesson_order} of 3</h2>";
                            ?>

                            <?php
                            echo "<h3 class='text-center mb-3'>{$fetchLesson->lesson_title}</h3>";
                            ?>

                            <div class="row d-block d-sm-flex justify-content-center mb-3">
                                <div class="btn_task col-5 mb-2 text-center">
                                    <!--TODO add onclick functionality -->
                                    <?php
                                    $previousLesson = $lesson-1;
                                    $nextLesson = $lesson+1;
                                    $urlNext = '';
                                    $inlineNext = '';
                                    $urlPrevious = '';
                                    $inlinePrevious = '';
                                    $ifLast = '';
                                    if($lesson==1){
                                        $urlNext = 'lesson.php?courseID='.$courseID.'&modOrder='.$module.'&lessonOrder='.$nextLesson;
                                        $urlPrevious = '#';
                                        $inlineNext = 'Go to lesson '.$nextLesson;
                                        $inlinePrevious = '---';
                                    }
                                    if($lesson<3 and $lesson>1){
                                        $urlNext = 'lesson.php?courseID='.$courseID.'&modOrder='.$module.'&lessonOrder='.$nextLesson;
                                        $urlPrevious = 'lesson.php?courseID='.$courseID.'&modOrder='.$module.'&lessonOrder='.$previousLesson;
                                        $inlineNext = 'Go to lesson '.$nextLesson;
                                        $inlinePrevious = 'Go to lesson '.$previousLesson;
                                    }
                                    if($lesson==3 and $module < 6) {
                                        $nextModule = $module + 1;
                                        $urlNext = 'lesson.php?courseID='.$courseID.'&modOrder='.$nextModule.'&lessonOrder=1';
                                        $urlPrevious = 'lesson.php?courseID='.$courseID.'&modOrder='.$module.'&lessonOrder='.$previousLesson;
                                        $inlineNext = 'Go to new module';
                                        $inlinePrevious = 'Go to lesson '.$previousLesson;

                                    }
                                    if($lesson==3 && $module==6){
                                        $urlPrevious = 'lesson.php?courseID='.$courseID.'&modOrder='.$module.'&lessonOrder='.$previousLesson;
                                        $inlinePrevious = 'Go to lesson '.$previousLesson;
                                    }


                                    echo "<a href='$urlPrevious'><button class='btn btn-outline-primary' style='width: 100%' role='button'>$inlinePrevious</button></a>
                                </div>
                                <div class='btn_task col-5 mb-2 text-center'>
                                    <!--TODO add onclick functionality -->";?>
                                    <?php
                                    if($lesson==3 && $module==6){
                                        echo "<button type='button' class='nav-item btn btn-primary' style='width: 100%' data-bs-toggle='modal' data-bs-target='#rating_modal'>Rate the course</button>";
                                    }
                                    else{
                                        echo "<a class='btn btn-outline-primary' style='width: 100%' href='$urlNext' role='button'>$inlineNext</a>";
                                    }
                                    ?>



                                </div>

                            </div>
                        </div>

                        <div class="media_container">
                            <iframe class="responsive_iframe" src="https://www.youtube.com/embed/2Si7ah_h32s" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <?php
                        echo "<p class='mt-4'>$fetchLesson->lesson_transcript</p>";
                        ?>

                    </div>
                </div>
                <div class="web_tasks col-xl-5 d-flex justify-content-end">
                    <div>
                        <?php
                        echo "
                        <h2 class='text-center'><b>Current lesson: </b>Lesson $lesson of 3</h2>
                        <h3 class='text-center mb-3'>{$fetchLesson->lesson_title}</h3>
                        <div class='row d-flex justify-content-center mb-5'>
                            <div class='col-5'>
                                <!--TODO add onclick functionality -->
                                <a class='btn btn-outline-primary' style='width: 100%' href='$urlPrevious' role='button'>$inlinePrevious</a>
                            </div>
                            <div class='col-5'>
                                <!--TODO add onclick functionality -->";
                        ?>
                        <?php
                        if($lesson==3 && $module==6){
                            echo "<button type='button' class='nav-item btn btn-primary' style='width: 100%' data-bs-toggle='modal' data-bs-target='#rating_modal'>Rate the course</button>";
                        }
                        else{
                            echo "<a class='btn btn-outline-primary' style='width: 100%' href='$urlNext' role='button'>$inlineNext</a>";
                        }
                        ?>
                    </div>
                </div>



                        <!--Rating MODAL-->
                        <div class="modal fade" id="rating_modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h1 class="text-center mb-3" style="color: #ffdf00;"><b>Congratulations!</b></h1>
                                        <?php
                                        echo "<p class='fs-2 text-center mb-4'><b>You have finished the {$fetchCourse->course_title} course!</b></p>";
                                        ?>

                                        <p class="fs-3 text-center mb-5">Why not to rate the course to help other know what it's like?</p>
                                        <div class="d-flex justify-content-center mb-5">
                                            <img onmouseenter="ratingHover(this.id)" onclick="ratingClick(this.id)"id="star-1" class="star mx-2" src="data/star-outline.png" height="75" style="cursor: pointer">
                                            <img onmouseenter="ratingHover(this.id)" onclick="ratingClick(this.id)"id="star-2" class="star mx-2" src="data/star-outline.png" height="75" style="cursor: pointer">
                                            <img onmouseenter="ratingHover(this.id)" onclick="ratingClick(this.id)"id="star-3" class="star mx-2" src="data/star-outline.png" height="75" style="cursor: pointer">
                                            <img onmouseenter="ratingHover(this.id)" onclick="ratingClick(this.id)"id="star-4" class="star mx-2" src="data/star-outline.png" height="75" style="cursor: pointer">
                                            <img onmouseenter="ratingHover(this.id)" onclick="ratingClick(this.id)"id="star-5" class="star mx-2" src="data/star-outline.png" height="75" style="cursor: pointer">
                                        </div>
                                        <!--hidden form to send rating result-->
                                        <?php
                                        echo "
                                        <form id='form_rating' class='mt-5' method='post' action='ratingAction.php' hidden>";
                                        ?>

                                            <input type="number" name="rating" id="rating"/>
                                        <?php
                                        echo "
                                        <input type='number' name='courseID' value='$courseID'/>";
                                        ?>

                                        </form>
                                        <div class="d-flex justify-content-center mb-3">
                                            <button form="form_rating" name='submit' type="submit" class="btn btn-primary">Submit your rating</button>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Style for stars-->
                        <style>
                            @media only screen and (max-width: 500px){
                                .star{
                                    height: 50px;
                                    margin: 0px 5px !important;
                                }
                            }
                        </style>



                        <div class="row task border border-3 rounded-2 d-flex justify-content-center mb-3" style="cursor: pointer">
                            <div class="m-2 col-3" style="background: #5d5d5d">
                            </div>
                            <div class="col-8">
                                <h5 class="mt-3"><b>Task 1</b></h5>
                                <p class="fs-5">Introduction to time management</p>
                            </div>
                        </div>
                        <div class="row task border border-3 rounded-2 d-flex justify-content-center mb-3" style="cursor: pointer">
                            <div class="m-2 col-3" style="background: #5d5d5d">
                            </div>
                            <div class="col-8">
                                <h5 class="mt-3"><b>Task 1</b></h5>
                                <p class="fs-5">Introduction to time management</p>
                            </div>
                        </div><div class="row task border border-3 rounded-2 d-flex justify-content-center mb-3" style="cursor: pointer">
                        <div class="m-2 col-3" style="background: #5d5d5d">
                        </div>
                        <div class="col-8">
                            <h5 class="mt-3"><b>Task 1</b></h5>
                            <p class="fs-5">Introduction to time management</p>
                        </div>
                    </div><div class="row task border border-3 rounded-2 d-flex justify-content-center mb-3" style="cursor: pointer">
                        <div class="m-2 col-3" style="background: #5d5d5d">
                        </div>
                        <div class="col-8">
                            <h5 class="mt-3"><b>Task 1</b></h5>
                            <p class="fs-5">Introduction to time management</p>
                        </div>
                    </div>


                    </div>
                </div>
            <a onclick="topFunction()" id="return-to-top"><i class="icon-chevron-up"></i></a> <!--Return to top button-->
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
            <a href="general_functions.php?logout=true"><img class="pointer logout mb-2 mt-3 mx-2" src="data/logout.png" alt="Logout" width="44" style="cursor: pointer"/></a>
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



                    <div class="mb-3">
                        <input type="text" id="task_title" class="form-control form-control-sm mb-2 mx-1" placeholder="New task">
                        <input type="text" id="task_text" class="form-control form-control-sm mx-1" placeholder="Task comment">
                        <div class="d-flex justify-content-center mt-2">

                            <!-- TODO Add PHP script to insert task and refresh tasks-->

                            <button type="button" onclick="add('task')" class="btn btn-outline-info btn-sm"> + Task </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--JS for stars rating-->
    <script>
        const stars = ['star-1', 'star-2', 'star-3', 'star-4', 'star-5'];
        function ratingHover(id) {
            count = stars.indexOf(id);
            document.getElementById("rating").value = count+1;
            for(let i=0; i<stars.length; i++) {
                star = document.getElementById(stars[i]);
                if(i<=count) {
                    star.src = "data/star.png";
                } else {
                    star.src = "data/star-outline.png";
                }
            }
        }
        function ratingClick(id) {
            count = stars.indexOf(id);
            document.getElementById("rating").value = count+1;
            //Code duplicate for small screen sizes, because the dont support onHover event
            for(let i=0; i<stars.length; i++) {
                star = document.getElementById(stars[i]);
                if(i<=count) {
                    star.src = "data/star.png";
                } else {
                    star.src = "data/star-outline.png";
                }
            }
        }
    </script>
                                <!-- LOAD -->
    <script>
        load_notes();
        load_tasks();


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
    </html>
<?php
    }
    else header("Location: dashboard.php"); // if logged in but it's not user's active course
}
else header("Location: courses.php"); // if not logged in
?>
