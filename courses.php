<?php
require_once 'general_functions.php';
require_once 'courseQueries.php';
set_session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Courses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="icon" href="data/brainup.png">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="courses.css">
</head>
<?php
// scroll to the list of courses if category has been selected
if(isset($_GET['cat'])){
    echo "<body onLoad='window.scroll(0, 1000)'>";
}
else echo "<body>";
?>
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
                <li class="nav-item "> <a class="nav-link active" href="courses.php">Courses</a> </li>
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
                <div class="my-4">
                    <div class="row d-flex justify-content-center">
                        <div class="col-7 d-none d-lg-flex justify-content-center align-items-center">
                            <img src="data/login.jpeg" class="img-fluid">
                        </div>
                        <div class="col-12 col-lg-4">
                            <!---------------->
                            <!-- LOGIN FORM -->
                            <!---------------->
                                <form class="mt-5" method="post" action="logonVerification.php">
                                    <h3 class="my-5 text-center"><b>Login to BrainUp</b></h3>
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
                            <img src="data/login.jpeg" class="img-fluid">
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
                                    <button type="submit" name="submit" class="btn btn-primary" style="width: 100%">Continue</button>
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
                        <div class="col-7 d-none d-lg-flex justify-content-center align-items-center">
                            <img src="data/login.jpeg" class="img-fluid">
                        </div>
                        <div class="col-10 col-lg-4">
                            <!------------------------->
                            <!-- CREATE ACCOUNT FORM -->
                            <!------------------------->
                            <h3 class="mb-4 text-center"><b>Create a BrainUp account</b></h3>
                            <form method="post" action="registrationProcess.php">
                                <div class="mb-3">
                                    <label for="inputName" class="form-label">Full Name</label>
                                    <input type="text" name="fullName" class="form-control" id="inputName" placeholder="Joe Bloggs" required>
                                </div>
                                <label for="day" class="form-label">Date of Birth</label>
                                <div class="d-flex justify-content-between mb-3">
                                    <select id="day" name="day" class="form-select" aria-label="Default select example" style="width: 20%" required>
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
                                    <select class="form-select" name="month" aria-label="Default select example" style="width: 50%" required>
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
                                    <select id="year" name="year" class="form-select" aria-label="Default select example" style="width: 25%" required>
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
                                    <input id="signup-email" name="email" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control" id="signupInputEmail1" required>
                                    <div id="emailHelp2" class="form-text">We'll never share your email with anyone else.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="signupInputPassword1" class="form-label">Password</label>
                                    <input id="signup-pass" name="password" type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}$" class="form-control" id="signupInputPassword1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="signupConfirmPassword1" class="form-label">Confirm Password</label>
                                    <input type="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}$" class="form-control" id="signupConfirmPassword1" required>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" name="submit" class="form-check-input" id="terms" >
                                    <label class="form-check-label" for="terms">I agree to the
                                        <a class="link-primary" data-bs-target="#termsModal" data-bs-toggle="modal">terms and conditions </a>
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <button id="signUpSubmit" type="submit" class="btn btn-primary">Sign Up</button>
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

<main class="d-flex justify-content-center">

    <div class="container">
        <h3 class="text-center mb-3"><b>Our featured courses</b></h3>
        <div class="featured_wrapper">
            <div class="scrolling-wrapper pt-4">

                <!-- SHOW FIRST 5 COURSES WITH A HIGHEST RATING--->
                <?php
                    $getTop = extr_top_courses();
                    $i = 1;
                    while($i<=5){
                        $i=$i+1;
                        $top = $getTop->fetchObject();
                        echo "
                    <a href='coursePage.php?courseID={$top->course_id}'>
                    <div class='featured card col-10 col-md-7 col-lg-4 ms-4'>
                        <img src='{$top->course_image_laptop}' class='img-fluid' alt='course Image'/>
                        <h4 class='ms-3 my-4'><b>{$top->course_title}</b></h4>
                        <p class='mx-3'>{$top->course_brief_desc}</div></a>";
                    }
                ?>


            </div>
        </div>

        <h3 class="category_text text-center mb-5"><b>Courses by category</b></h3>
        <div class="category_row row m-0">
            <div class="category_wrapper col-sm-6 col-lg-3 px-2 mb-3">
                <?php
                if(isset($_GET['cat']) and $_GET['cat'] === 'TMNG'){
                    echo "<a href='courses.php'>
                          <div class='blue category' style='background: #85adff !important; color: white;'>";
                }
                else{
                    echo "<a href='courses.php?cat=TMNG'>
                          <div class='blue category'>";
                }
                ?>
                    <div class="image_wrapper d-flex align-items-center justify-content-center my-1">
                        <img src="data/cat1.png" class="category_img img-fluid " alt="category image"/>
                    </div>
                    <div class="text_wrapper d-flex align-items-center justify-content-center">
                        <h5 class="text_category text-center"><b>Time management</b></h5>
                    </div>
                </div>
                 <?php
                echo "</a>";
                ?>
            </div>
            <div class="category_wrapper col-sm-6 col-lg-3 px-2 mb-3">
                <?php
                if(isset($_GET['cat']) and $_GET['cat'] === 'CWOT') {
                    echo "<a href='courses.php'>
                          <div class='green category' style='background: #a1ff9c !important; color: white;'>";
                }
                else{
                    echo "<a href='courses.php?cat=CWOT'>
                          <div class='green category'>";
                }
                ?>
                    <div class="image_wrapper d-flex align-items-center justify-content-center my-1">
                        <img src="data/cat2.png" class="category_img img-fluid" alt="category image"/>
                    </div>
                    <div class="text_wrapper d-flex align-items-center justify-content-center">
                        <h5 class="text_category text-center"><b>Coping with Working Online</b></h5>
                    </div>
                </div>
                <?php
                echo "</a>";
                ?>
            </div>
            <div class="category_wrapper col-sm-6 col-lg-3 px-2 mb-3">
                <?php
                if(isset($_GET['cat']) and $_GET['cat'] === 'IDGN') {
                    echo "<a href='courses.php'>
                          <div class='light_blue category' style='background: #8bcbff !important; color: white;'>";
                }
                else{
                    echo "<a href='courses.php?cat=IDGN'>
                          <div class='light_blue category'>";
                }
                ?>
                    <div class="image_wrapper d-flex align-items-center justify-content-center my-1">
                        <img src="data/cat3.png" class="category_img img-fluid" alt="category image"/>
                    </div>
                    <div class="text_wrapper">
                        <h5 class="text_category text-center"><b>Idea generation</b></h5>
                    </div>
                </div>
                <?php
                echo "</a>";
                ?>
            </div>
            <div class="category_wrapper col-sm-6 col-lg-3 px-2 mb-3">
                <?php
                if(isset($_GET['cat']) and $_GET['cat'] === 'GRTH') {
                    echo "<a href='courses.php'>
                          <div class='purple category' style='background: #cc93ff !important; color: white;'>";
                }
                else{
                    echo "<a href='courses.php?cat=GRTH'>
                          <div class='purple category'>";
                }
                ?>
                    <div class="image_wrapper d-flex align-items-center justify-content-center my-1">
                        <img src="data/cat4.png" class="category_img img-fluid" alt="category image"/>
                    </div>
                    <div class="text_wrapper d-flex align-items-center justify-content-center">
                        <h5 class="text_category text-center"><b>Growth</b></h5>
                    </div>
                </div>
                <?php
                echo "</a>";
                ?>
            </div>
        </div>

        <div class="category_row row m-0">
            <div class="category_wrapper col-sm-6 col-lg-3 px-2 mb-3">
                <?php
                if(isset($_GET['cat']) and $_GET['cat'] === 'PRFM') {
                    echo "<a href='courses.php'>
                          <div class='purple category' style='background: #cc93ff !important; color: white;'>";
                }
                else{
                    echo "<a href='courses.php?cat=PRFM'>
                          <div class='purple category'>";
                }
                ?>
                    <div class="image_wrapper d-flex align-items-center justify-content-center my-1">
                        <img src="data/cat6.png" class="category_img img-fluid" alt="category image"/>
                    </div>
                    <div class="text_wrapper d-flex align-items-center justify-content-center">
                        <h5 class="text_category text-center"><b>Performance</b></h5>
                    </div>
                </div>
                <?php
                echo "</a>";
                ?>
            </div>
            <div class="category_wrapper col-sm-6 col-lg-3 px-2 mb-3">
                <?php
                if(isset($_GET['cat']) and $_GET['cat'] === 'MTRC') {
                    echo "<a href='courses.php'>
                          <div class='orange category' style='background: #ffa98b !important; color: white;'>";
                }
                else{
                    echo "<a href='courses.php?cat=MTRC'>
                          <div class='orange category'>";
                }
                ?>
                    <div class="image_wrapper d-flex align-items-center justify-content-center my-1">
                        <img src="data/cat7.png" class="category_img img-fluid" alt="category image"/>
                    </div>
                    <div class="text_wrapper d-flex align-items-center justify-content-center">
                        <h5 class="text_category text-center"><b>Mental Resilience</b></h5>
                    </div>
                </div>
                 <?php
                echo "</a>";
                ?>
            </div>
            <div class="category_wrapper col-sm-6 col-lg-3 px-2 mb-3">
                <?php
                if(isset($_GET['cat']) and $_GET['cat'] === 'RDTQ') {
                    echo "<a href='courses.php'>
                          <div class='green category' style='background: #a1ff9c !important; color: white;'>";
                }
                else{
                    echo "<a href='courses.php?cat=RDTQ'>
                          <div class='green category'>";
                }
                ?>
                    <div class="image_wrapper d-flex align-items-center justify-content-center my-1">
                        <img src="data/cat8.png" class="category_img img-fluid" alt="category image"/>
                    </div>
                    <div class="text_wrapper d-flex align-items-center justify-content-center">
                        <h5 class="text_category text-center"><b>Reading techniques</b></h5>
                    </div>
                </div>
                <?php
                echo "</a>";
                ?>
            </div>
            <div class="category_wrapper col-sm-6 col-lg-3 px-2 mb-3">
                <?php
                    if(isset($_GET['cat']) and $_GET['cat'] === 'MTVN') {
                        echo "<a href='courses.php'>
                          <div class='blue category' style='background: #8bcbff !important; color: white;'>";
                }
                else{
                    echo "<a href='courses.php?cat=MTVN'>
                          <div class='blue category'>";
                }
                ?>
                    <div class="image_wrapper d-flex align-items-center justify-content-center my-1">
                        <img src="data/cat1.png" class="category_img img-fluid" alt="category image"/>
                    </div>
                    <div class="text_wrapper d-flex align-items-center justify-content-center">
                        <h5 class="text_category text-center"><b>Motivation</b></h5>
                    </div>
                </div>
                <?php
                echo "</a>";
                ?>
            </div>
        </div>

        <?php
        if(isset($_GET['cat'])){
            $category = $_GET['cat'];
            $fetchCourses = extr_by_category($category);
            $fetchName = category_name($category);
            $name = $fetchName -> fetchObject();

            echo "<h3 class='allCourses_text text-center mb-5'><b>$name->cat_name</b></h3>
                  <div class='row mt-3 d-flex justify-content-between'>";
            while($byCategory = $fetchCourses -> fetchObject()){
                echo "
                    <div class='col-sm-12 col-md-6 col-lg-4 px-3 mb-4'>
                        <div class='allCourse card'>
                        <a href='coursePage.php?courseID={$byCategory->course_id}'>
                            <img src='{$byCategory->course_image_laptop}' class='img-fluid' alt='course image'/>
                            <h4 class='ms-3 my-4'><b>{$byCategory->course_title}</b></h4>
                            <p class='mx-3'>$byCategory->course_brief_desc
                            </a></div>
                    </div>";
            }
            echo "</div>";

        }
        else{
            echo "
            <!--All courses-->
        <h3 class='allCourses_text text-center mb-5'><b>All courses</b></h3>
        <div class='row mt-3 d-flex justify-content-between'>";
            $fetch = extr_all_courses();
            while($course = $fetch -> fetchObject()){
                echo "
        

            <div class='col-sm-12 col-md-6 col-lg-4 px-3 mb-4'>
                <div class='allCourse card'>
                <a href='coursePage.php?courseID={$course->course_id}'>
                    <img src='{$course->course_image_laptop}' class='img-fluid' alt='course image'/>
                    <h4 class='ms-3 my-4'><b>{$course->course_title}</b></h4>
                    <p class='mx-3'>$course->course_brief_desc
                    </a></div>
            </div>";
            }
            echo "</div>";
        }
        ?>
        
    </div>
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
