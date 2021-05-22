<?php
require_once 'general_functions.php';
require_once 'courseQueries.php';
set_session();
if(isset($_GET['courseID'])){
    $courseID = $_GET['courseID'];
    $descriptionQuery = extr_selected_course($courseID);
    $course = $descriptionQuery->fetchObject();
    if(!empty($course)){
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Course</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
            <link rel="icon" href="data/brainup.png">
            <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
            <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="coursePage.css">
        </head>
        <body>
        <nav id="navbar" class="navbar navbar-expand-lg sticky-top navbar-light mb-5 bg-body rounded">
            <div class="container-fluid">

                <!-- LOGO AND NAV TABS ---->
                <a class="navbar-brand mx-4 pb-3" href="home.html"> <img src="data/logo.png" width="120" height="40" class="d-inline-block" alt="logo of BrainUp"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-5 mb-2 mb-lg-0">
                        <li class="nav-item"> <a class="nav-link" href="home.html">Home</a> </li>
                        <li class="nav-item "> <a class="nav-link" href="courses.php">Courses</a> </li>
                    </ul>

                    <!-- SEARCH ---->
                    <form id="search_form" class="d-flex me-auto">
                        <input id="searchInput" class="form-control me-1" type="search" placeholder="Search for courses..." aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>


                </div>
                <!-- LOGIN BUTTON ---->
                <button type="button" id="loginBtn" class="nav-item btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#login_modal">Login</button>
            </div>
        </nav>

        <div class="modal fade" id="login_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-lg-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row my-4">
                            <div class="row d-flex justify-content-evenly">
                                <div class="col-7 d-none d-lg-block" style="background: grey"></div>
                                <div class="col-10 col-lg-4">
                                    <!---------------->
                                    <!-- LOGIN FORM -->
                                    <!---------------->
                                    <h3 class="mb-4 text-center"><b>Login to BrainUp</b></h3>
                                    <form method="post" action="logonVerification.php">
                                        <div class="mb-3">
                                            <label for="loginInputEmail1" class="form-label">Email address</label>
                                            <input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control" id="loginInputEmail1" aria-describedby="emailHelp" required>
                                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="loginInputPassword1" class="form-label">Password</label>
                                            <input type="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}$" class="form-control" id="loginInputPassword1" required>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="remember">
                                            <label class="form-check-label" for="remember">Remember me </label>
                                        </div>
                                        <div class="mb-2">
                                            <button id="loginSubmit" name="submit" type="submit" class="btn btn-primary">Sign In</button>
                                        </div>
                                        <div class="d-flex justify-content-center mb-3">
                                            <a data-bs-target="#forgotPass_modal" data-bs-dismiss="modal" data-bs-toggle="modal" class="link-primary">Forgot your password?</a>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <b>New here?</b>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <a class="link-primary" data-bs-target="#signup_modal" data-bs-dismiss="modal" data-bs-toggle="modal">Create a BrainUp account</a>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="forgotPass_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-lg-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="my-4">
                            <div class="row d-flex justify-content-center">
                                <div class="col-7 d-none d-lg-flex justify-content-center align-items-center">
                                    <img src="data/pexels-photo-4050315%20(1).jpeg" class="img-fluid">
                                </div>
                                <div class="col-12 col-lg-4">
                                    <!---------------------->
                                    <!-- FORGOT PASS FORM -->
                                    <!---------------------->
                                    <form class="mt-5" method="post" action="passwordReset.php">
                                        <h3 class="mt-5 text-center"><b>Lets try and reset your password</b></h3>
                                        <p class="mt-3 mb-5 fs-4 text-center">Enter the email address associated with your BrainUp account</p>
                                        <div class="mb-3">
                                            <label for="email_forgot" class="form-label">Email address</label>
                                            <input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control" id="email_forgot" aria-describedby="emailHelp" placeholder="joe.bloggs@example.com" required>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" name"submit" class="btn btn-primary" style="width: 100%">Continue</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="signup_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-lg-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row my-4">
                            <div class="row d-flex justify-content-evenly">
                                <div class="col-7 d-none d-lg-block" style="background: grey"></div>
                                <div class="col-10 col-lg-4">
                                    <!------------------------->
                                    <!-- CREATE ACCOUNT FORM -->
                                    <!------------------------->
                                    <h3 class="mb-4 text-center"><b>Create a BrainUp account</b></h3>
                                    <form method="post" action="registrationProcess.php">
                                        <div class="mb-3">
                                            <label for="inputName" class="form-label">Full Name</label>
                                            <input type="text" name="fullName" class="form-control" id="inputName" placeholder="Joe Bloggs">
                                        </div>
                                        <label for="day" class="form-label">Date of Birth</label>
                                        <div class="d-flex justify-content-between mb-3">
                                            <select id="day" name="day" class="form-select" aria-label="Default select example" style="width: 20%">
                                                <script>
                                                    var selectList = document.getElementById("day");
                                                    //Create and append the options
                                                    for (var i = 1; i <= 31; i++) {
                                                        var option = document.createElement("option");
                                                        option.setAttribute("value", i);
                                                        option.text = i;
                                                        selectList.appendChild(option);
                                                    }
                                                </script>
                                            </select>
                                            <select class="form-select" name="month" aria-label="Default select example" style="width: 50%">
                                                <option value="1" selected>January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                            <select id="year" name="year" class="form-select" aria-label="Default select example" style="width: 25%">
                                                <script>
                                                    var selectList = document.getElementById("year");
                                                    //Create and append the options
                                                    for (var i = 2021; i >= 1901; i--) {
                                                        var option = document.createElement("option");
                                                        option.setAttribute("value", i);
                                                        option.text = i;
                                                        selectList.appendChild(option);
                                                    }
                                                </script>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="signupInputEmail1" class="form-label">Email address</label>
                                            <input type="email" name="email" class="form-control" id="signupInputEmail1" aria-describedby="emailHelp">
                                            <div id="emailHelp2" class="form-text">We'll never share your email with anyone else.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="signupInputPassword1" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="signupInputPassword1">
                                        </div>
                                        <div class="mb-3">
                                            <label for="signupConfirmPassword1" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="signupConfirmPassword1">
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="terms">
                                            <label class="form-check-label" for="terms">I agree to the
                                                <a class="link-primary" data-bs-target="#termsModal" data-bs-toggle="modal">terms and conditions </a>
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <button id="signUpSubmit" name"submit" type="submit" class="btn btn-primary">Sign Up</button>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <b>Already have an account?</b>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <a class="link-primary" data-bs-target="#login_modal" data-bs-dismiss="modal" data-bs-toggle="modal">Log In</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--TERMS ADN CONDITIONS-->
        <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Terms and Conditions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis pulvinar turpis, nec commodo odio. Quisque quis mollis dolor. Phasellus tempus elit et nulla placerat interdum. Aliquam aliquet ac libero non ultricies. In hac habitasse platea dictumst. Suspendisse dui est, auctor et justo sed, euismod pretium odio. In euismod condimentum dolor, ac eleifend dolor pellentesque et. Suspendisse quis fringilla nulla. Integer tincidunt neque metus.

                        Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis convallis arcu sit amet sapien vehicula porta. Pellentesque sed felis scelerisque, consectetur erat et, rutrum urna. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris laoreet diam et egestas bibendum. Nam blandit nulla id nisi euismod ultricies. Vestibulum nisi sapien, semper in suscipit sit amet, posuere ut mauris. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris sollicitudin lorem non ligula pretium auctor. In finibus fermentum lorem, id efficitur lacus commodo sit amet. Morbi eget convallis ligula. Phasellus vel convallis urna. Praesent sed imperdiet purus. Nulla condimentum augue in viverra placerat. Fusce eget sapien erat. Nunc non tellus lacus.

                        Nam eu nibh gravida, tempus quam quis, luctus turpis. Fusce ipsum risus, gravida eget nibh in, mattis dictum sapien. Cras dictum gravida pulvinar. Nunc eu mi nec felis scelerisque euismod a a orci. Sed vel sem eu diam porttitor semper. Sed sit amet rhoncus leo. Ut sed eros sapien. Vestibulum elementum laoreet elit, eu ultricies erat luctus a. Aliquam nunc arcu, tincidunt in dignissim at, sollicitudin et massa. Sed velit dolor, hendrerit eleifend lobortis at, rutrum sed neque. Donec et odio vestibulum leo porta mollis id et leo.

                        Nullam dictum lectus nunc, eget vulputate mi pretium id. Suspendisse scelerisque vestibulum nunc congue finibus. Duis et fermentum tortor, quis rhoncus leo. Nulla sagittis nisl nunc. Fusce sed magna at ipsum porttitor eleifend at in libero. Curabitur porta dapibus accumsan. Duis et elit condimentum dolor faucibus viverra. Sed eu imperdiet augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec facilisis blandit urna, at rhoncus velit efficitur et. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras at ex vitae ex laoreet maximus. In hac habitasse platea dictumst. Praesent tempus orci et arcu interdum, consequat viverra nibh euismod. Ut venenatis nunc elit, id aliquet arcu iaculis mollis.

                        Nunc placerat nulla quis velit iaculis venenatis vitae vulputate quam. Duis vel eleifend augue, sit amet ullamcorper augue. Maecenas mi augue, facilisis vitae ipsum vehicula, mattis placerat tellus. Donec aliquet ante non risus vulputate porttitor. Mauris magna lectus, elementum egestas dignissim ut, faucibus vitae orci. Integer sollicitudin, ligula at sodales laoreet, ante ante blandit tortor, ut pulvinar risus leo non nisi. In convallis tempus commodo. Nam at tristique metus, ut vulputate nulla.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <main>
            <div class="d-flex justify-content-center" style="background: #d9e8ff">
                <div class="container">
                    <div class="row py-4 border-bottom border-3">
                        <!-- Course image placeholder mobile/tablet---->
                        <div class="mb-4 d-md-block d-lg-none col-lg-7 col-md-12">
                        <?php
                            echo "<img class='img-fluid' src='{$course->course_image}' alt='course Image mobile'/>";
                            ?>
                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div class="course_header d-flex mb-4">
                            <?php
                                $catImg = $course -> cat_image;

                                echo "<img class='img-fluid' src='$catImg' style='height: 50px' alt='course Image web'/>";

                                echo "
                                <h2 class='ms-3'><b>{$course->course_title}</b></h2>
                            </div>
                            <p class='course_text me-4 mb-4 fs-5'>{$course->course_desc}</p>

                            <p class='fs-5 text-center'><b>Time to complete:</b> {$course->duration} hrs</p>
                            <p class='fs-5 text-center'><b>Difficulty:</b> {$course->difficulty}</p>
                            <div class='button_wrapper d-flex justify-content-center'>";
                                $active = check_course($courseID);
                                if($active === true) {
                                    echo "
                                <a href='lesson.html'><button class='course_pay btn btn-primary mt-2'>Continue the course</button></a> ";
                                }
                                else {
                                    if (isset($_COOKIE['logon_status'])) {
                                    $hash = $_COOKIE['hash'];
                                    echo "
                            <a href='payment.php?courseID=$courseID&payment=$hash'><button class='course_pay btn btn-primary mt-2'>Start Course £{$course->course_price}</button></a> ";
                                    }
                                    else{
                                        echo "
                                <a href='payment.php?courseID=$courseID&payment=false'><button class='course_pay btn btn-primary mt-2'>Start Course £{$course->course_price}</button></a> ";
                                    }
                                }
                                echo"</div>";
                            ?>
                        </div>
                        <!-- Course image placeholder web---->
                        <div class="d-md-none d-lg-block col-lg-7 col-md-12" style="background: grey">
                        </div>
                    </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="container">
                        <h3 class="text-start mt-5"><b>Course content</b></h3>

                    <div id="modules_wrapper_web" class="row mt-4  d-none d-lg-flex">

                        <?php
                            $i = 0;
                            $syllabusQuery = extr_syllabus($courseID);
                            while($syllabus = $syllabusQuery->fetchObject()) {
                                $i = $i+1;
                            echo "
                            <div class='col-lg-3 col-sm-6 col-12'>
                                <div class='module_wrapper mt-lg-2 mt-1'>
                                    <a class='module_card btn btn btn-light border border-dark mb-3' data-bs-toggle='collapse' href='#collapseExample$i' role='button' aria-expanded='false' aria-controls='collapseExample'>
                                        <h5 class='mb-2 text-center'><b>Module {$syllabus->mod_order}: {$syllabus->mod_title}</b></h5>
                                        <p class='text-start fs-6 d-lg-block d-none'>{$syllabus->brief_desc}</p>
                                        <div class='wrapper'>
                                            <div class='d-flex float-start'>
                                                <img src='data/clock.svg' class='img fluid' alt='clock icon'/>
                                                <span class='fs-7 ms-1'>{$syllabus->mod_duration} hrs</span>
                                            </div>
                                            <div class='float-end'>
                                                <img class='dropdown-icon' src='data/arrow-down-square.svg' width='25' alt='dropdown'/>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>";}
                            ?>

                    </div>
            <!-- MODULES MAIN END---->

                <?php
                        $syllabusQuery = extr_syllabus($courseID);
                        $i = 0;
                        while($syllabus = $syllabusQuery->fetchObject()) {
                            $i = $i+1;
                            echo "
                        <div class='collapse mb-3' id='collapseExample$i'>
                            <div class='card card-body'>
                                <div class='row d-flex justify-content-evenly'>
                                    <div class='col-lg-8 col-12'>
                                        <h5 class='mb-2 text-start'><b>Module {$syllabus->mod_order}: {$syllabus->mod_title}</b></h5>
                                        {$syllabus->mod_desc}
                                    </div>
                                    <div class='col-3 d-lg-block d-none' style='background: grey'>
                                    </div>
                                </div>
                            </div>
                        </div>";}
                        ?>


        <!-- MODULES EXPAND END---->

                <div id="modules_wrapper_mobile" class="row mt-4  d-flex d-lg-none">

                <?php
                $syllabusQuery = extr_syllabus($courseID);
                $i = 0;
                while($syllabus = $syllabusQuery->fetchObject()) {
                    $i = $i+1;
                echo "
                        <div class='col-12'>
                            <div class='module_wrapper mt-lg-2 mt-1'>
                                <a class='module_card btn btn btn-light border border-dark mb-3' data-bs-toggle='collapse' href='#collapseExample{$i}M' role='button' aria-expanded='false' aria-controls='collapseExample'>
                                    <h5 class='mb-2'><b>Module {$syllabus->mod_order}: {$syllabus->mod_title}</b></h5>
                                </a>
                            </div>

                        </div>
                        <div class='collapse mb-3' id='collapseExample{$i}M'>
                            <div class='card card-body'>
                                <div class='row d-flex justify-content-evenly'>
                                    <div class='col-lg-8 col-12'>
                                        <h5 class='mb-2 text-start'><b>Module {$syllabus->mod_order}: {$syllabus->mod_title}</b></h5>
                                        {$syllabus->mod_desc}                
                                    </div>
                                    <div class='col-3 d-lg-block d-none' style='background: grey'>
                                    </div>
                                </div>
                            </div> 
                        </div>";
                }
                ?>

                </div>

        <!-- MODULES EXPAND MOBILE END---->


                <!-- Return to top button ---->
                <a onclick="topFunction()" id="return-to-top"><i class="icon-chevron-up"></i></a> <!--Return to top button-->
                <script>
                    btn = document.getElementById("return-to-top");
                    nav = document.getElementById("navbar");
                    function topFunction() {
                        document.body.scrollTop = 0; // For Safari
                        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                    }
                    window.onscroll = function (){
                        if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                            btn.style.display = "block";
                            nav.classList.add('shadow');
                        } else {
                            btn.style.display = "none";
                            nav.classList.remove('shadow');
                        }
                    };
                </script>
            </div>
        </main>
        <footer class="mt-5 d-md-flex justify-content-evenly">
            <div class="p-0 copyright d-flex justify-content-center">
                <p class="text center mt-4 fs-6" style="color: white"><b>© BrainUp 2021</b></p>
            </div>
            <div class="p-0 social d-flex justify-content-center">
                <p class="text center mt-1 mt-md-4 fs-6" style="color: white"><b>Find us on social media: </b></p>
                <a href="https://facebook.com" class="ms-2 mt-md-3">
                    <img src="data/facebook.png" class="img-fluid" style="width: 30px">
                </a>
                <a href="https://facebook.com" class="ms-2 mt-md-3">
                    <img src="data/facebook.png" class="img-fluid" style="width: 30px">
                </a>
                <a href="https://facebook.com" class="ms-2 mt-md-3">
                    <img src="data/facebook.png" class="img-fluid" style="width: 30px">
                </a>
            </div>
        </footer>
        </body>
        </html>
<?php
    }// end if course ID exists
    else header("Location: courses.php");
}// end if isset course ID
else header("Location: courses.php");
?>
