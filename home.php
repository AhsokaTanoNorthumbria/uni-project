<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"
      xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="UTF-8">
    <title>BrainUp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="icon" href="data/brainup.png">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="home.css">
</head>

<body>

<nav id="navbar" class="navbar navbar-expand-lg sticky-top navbar-light mb-5 bg-body rounded">
    <div class="container-fluid">

        <!-- LOGO AND NAV TABS ---->
        <a class="navbar-brand mx-4 pb-3" href="home.php"> <img src="data/logo.png" width="120" height="40" class="d-inline-block" alt="logo of BrainUp"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-5 mb-2 mb-lg-0">
                <li class="nav-item"> <a class="nav-link active" href="home.php">Home</a> </li>
                <li class="nav-item "> <a class="nav-link" href="courses.php">Courses</a> </li>
            </ul>


        </div>
        <!-- LOGIN BUTTON ---->
        <?php
        if(isset($_COOKIE['logon_status'])){
            echo "<button type='button' onclick='logout()' id='logoutBtn' class='btn btn-primary' style='display: block !important;'>Logout</button>";
        }
        else{
            echo "<button type='button' id='loginBtn' class='nav-item btn btn-primary me-3' data-bs-toggle='modal' data-bs-target='#login_modal'>Login</button>
                        <form action='#' method='get'></form>";
        }
        ?>
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

        <div class="row">
            <!----- Image --->
            <div class="image col-md-7 col-12 d-flex justify-content-center align-items-center" style="height: fit-content">
                <video autoplay muted loop src="data/demo%20video.mp4" class="img-fluid" style="width: 100% !important; height: 100% !important; border:none;"></video>
            </div>
            <div class="d-flex justify-content-center align-items-center col-md-5 col-xs-12">
                <!----- Sign Up form --->
                <form action="#" method="get">
                    <h3 class="mb-3 mt-4 text-center"><b>Create an account now</b></h3>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Please enter a valid email address" onkeyup='swap_val(this.value, "signup-email")'/>
                    <label for="password" class="form-label mt-2">Password</label>
                    <input type="password" class="form-control" id="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}$" title="Password must be at least 8 characters long, contain 1 uppercase letter, 1 lowercase letter, 1 number and 1 symbol" onkeyup='swap_val(this.value, "signup-pass")'>
                    <button id="signUp_btn" data-bs-toggle="modal" data-bs-target="#signup_modal" class="form-control block btn btn-primary mt-3"> Sign Up</button>
                    <p class="mt-3">Already have an account? <a data-bs-toggle="modal" data-bs-target="#login_modal" style="text-decoration: underline !important;">Log In</a></p>
                </form>
            </div>
        </div>
        <script>
            var swap_val = function  (val, id){
                var input = document.getElementById(id);
                input.value = val;
            }
        </script>
        <div class="row border my-5">
                <img src="data/cq-widelaptop.jpg" class="img-fluid quiz_image col-md-7 col-sm-12" id="cq_wide">
                <img src="data/cq-tablet.jpg" class="img-fluid quiz_image col-md-7 col-sm-12" id="cq_tablet">
            <div class="quiz col-md-5 col-sm-12 py-3">
                <h3 class="quiz_header mt-4 text-center"><b>Not sure which course to choose?</b></h3>
                    <h5 class="quiz_text mt-4 text-center">Complete this short quiz to find out which courses are for you.</h5>
                <div class="wrapper d-flex justify-content-center" style="height: fit-content">
                    <button class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#quiz1"> Start Quiz!</button>
                </div>
            </div>
        </div>
        <!-------->
        <!--Quiz-->
        <!-------->
        <div class="modal fade" id="quiz1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-centered modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><b>Let us help you find the right course</b></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="row modal-body m-4 d-flex justify-content-center">
                        <div class="col-12 col-lg-8">
                            <div class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="text-center"><b>Question 1 of 4</b></h4>
                            <p class="text-center fs-4">Which areas of personal development do you struggle with the most?</p>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                        Managing my time
                                    </li>
                                    <li class="list-group-item">
                                        <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                        Keeping myself motivated
                                    </li>
                                    <li class="list-group-item">
                                        <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                        Thinking of new ideas
                                    </li>
                                    <li class="list-group-item">
                                        <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                        Getting the most out of Online Learning
                                    </li>
                                    <li class="list-group-item">
                                        <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                        Thinking of new ideas
                                    </li>
                                </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-primary mt-4" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#quiz2">Go to next question</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="quiz2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-centered modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><b>Let us help you find the right course</b></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="row modal-body m-4 d-flex justify-content-center">
                        <div class="col-12 col-lg-8">
                            <div class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="text-center"><b>Question 2 of 4</b></h4>
                            <p class="text-center fs-4">Which areas of personal development do you struggle with the most?</p>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                        Managing my time
                                    </li>
                                    <li class="list-group-item">
                                        <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                        Keeping myself motivated
                                    </li>
                                    <li class="list-group-item">
                                        <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                        Thinking of new ideas
                                    </li>
                                    <li class="list-group-item">
                                        <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                        Getting the most out of Online Learning
                                    </li>
                                    <li class="list-group-item">
                                        <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                        Thinking of new ideas
                                    </li>
                                </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-primary mt-4" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#quiz3">Go to next question</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="quiz3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-centered modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><b>Let us help you find the right course</b></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="row modal-body m-4 d-flex justify-content-center">
                        <div class="col-12 col-lg-8">
                            <div class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="text-center"><b>Question 3 of 4</b></h4>
                            <p class="text-center fs-4">Which areas of personal development do you struggle with the most?</p>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                    Managing my time
                                </li>
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                    Keeping myself motivated
                                </li>
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                    Thinking of new ideas
                                </li>
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                    Getting the most out of Online Learning
                                </li>
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                    Thinking of new ideas
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-primary mt-4" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#quiz4">Go to next question</button>
                    </div>
                </div>
            </div>
        </div>
                <div class="modal fade" id="quiz4" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-centered modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><b>Let us help you find the right course</b></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="row modal-body m-4 d-flex justify-content-center">
                        <div class="col-12 col-lg-8">
                            <div class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="text-center"><b>Question 4 of 4</b></h4>
                            <p class="text-center fs-4">Which areas of personal development do you struggle with the most?</p>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                    Managing my time
                                </li>
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                    Keeping myself motivated
                                </li>
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="checkbox" name="1 qst">
                                    Thinking of new ideas
                                </li>
                                <li class="list-group-item">
                                    <input  class="form-check-input me-1" type="checkbox" name="1 qst">
                                    Getting the most out of Online Learning
                                </li>
                                <li class="list-group-item">
                                    <input  class="form-check-input me-1" type="checkbox" name="1 qst">
                                    Thinking of new ideas
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-primary mt-4" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#quiz_res">Results</button>
                        <form id="quiz_form" action="quiz_action.php">
                            <button type="submit" class="btn btn-outline-primary mt-4"> View Results </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="quiz_res" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-centered modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><b>Results</b></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="row modal-body m-4 d-flex justify-content-center">
                        <h2 class="text-center"><b>Thanks for completing the quiz</b></h2>
                        <div class="col-12 col-lg-8 mt-3">
                            <div class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h3 class="text-center">Based on your answers, we think you might like...</h3>
                            <div class="row mt-3 d-flex justify-content-evenly">
                                <div class="col-12 col-md-6 col-xl-5 mt-4">
                                    <div class="allCourse card">
                                        <a href="courses.html">
                                            <img src="data/pexels-photo-5965884.jpeg" class="img-fluid" alt="course image"/>
                                            <h4 class="ms-3 my-4"><b>Course Title</b></h4>
                                            <p class="mx-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Molestie ac feugiat sed lectus.</p>
                                        </a></div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-5 mt-4">
                                    <div class="allCourse card">
                                        <a href="courses.html">
                                            <img src="data/pexels-photo-5965884.jpeg"  class="img-fluid" alt="course image"/>
                                            <h4 class="ms-3 my-4"><b>Course Title</b></h4>
                                            <p class="mx-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Molestie ac feugiat sed lectus.</p>
                                        </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-md-7 mt-2">
                <h3 class="text-center mb-5"><b>Join BrainUp and see the benefits in 3 easy steps!</b></h3>
                <div class="wrapper mx-2">
                    <div class="row d-flex align-items-center mb-4">
                        <div class="col-1 p-0 me-3">
                            <img class="img-fluid" src="data/number1.png" width="60" height="60" alt="1">
                    </div>
                        <div class="col-10">
                    <h5 class="m-0">Complete our short quiz to help us understand you.</h5>
                        </div>
                    </div>

                    <div class="row d-flex align-items-center mb-4">
                        <div class="col-1 p-0 me-3">
                            <img class="img-fluid" src="data/number2.png" width="60" height="60" alt="2">
                        </div>
                        <div class="col-10">
                            <h5 class="m-0">We reccomend the best coures based on your current knowledge and skills.</h5>
                        </div>
                    </div>

                    <div class="row d-flex align-items-center mb-4">
                        <div class="col-1 p-0 me-3">
                            <img class="img-fluid" src="data/number3.png" width="60" height="60" alt="3">
                        </div>
                        <div class="col-10">
                            <h5 class="m-0">Pay once and complete the course in your own time and receive one-to-one support from our team <b>24 hours a day, 7 days a week</b></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="image col-md-5 mt-2 d-flex justify-content-center align-items-center">
                    <img src="data/pexels-photo-5965884.jpeg" class="img-fluid" id="top_web">
                    <img src="data/pexels-photo-5965884-1x1.jpeg" class="img-fluid" id="top_mobile">
            </div>
        </div>

        <div class="review_wrap">
            <h3 class="text-center mt-4"><b>What our users think... </b></h3>
            <div class="reviews row"> <!--Reviews-->

                <div class="review col-4 mt-4">
                    <ul class="d-flex p-0 justify-content-center">
                        <li><img src="data/star.png" width="30"  class="m-0 star img-responsive inline-block" alt="star" /></li>
                        <li><img src="data/star.png" width="30" class="m-0 star img-responsive inline-block" alt="star" /></li>
                        <li><img src="data/star.png" width="30"  class="m-0 star img-responsive inline-block" alt="star" /></li>
                        <li><img src="data/star.png" width="30"  class="m-0 star img-responsive inline-block" alt="star" /></li>
                        <li><img src="data/star.png" width="30"  class="m-0 star img-responsive inline-block" alt="star" /></li>
                    </ul>
                    <h6 class="review_text text-center"><i>"Using BrainUp makes me feel motivated for the rest of the day!"</i></h6>
                    <h6 class="text-center mt-3"><b>Tom, Manchester</b></h6>
                </div>

                <div class="review col-4 mt-4">
                    <ul class="d-flex p-0 justify-content-center">
                        <li><img src="data/star.png" width="30"  class="m-0 star img-responsive inline-block" alt="star" /></li>
                        <li><img src="data/star.png" width="30" class="m-0 star img-responsive inline-block" alt="star" /></li>
                        <li><img src="data/star.png" width="30"  class="m-0 star img-responsive inline-block" alt="star" /></li>
                        <li><img src="data/star.png" width="30"  class="m-0 star img-responsive inline-block" alt="star" /></li>
                        <li><img src="data/star.png" width="30"  class="m-0 star img-responsive inline-block" alt="star" /></li>
                    </ul>
                    <h6 class="review_text text-center"><i>"I like beeing able to contact my tutors whenever I need help"</i></h6>
                    <h6 class="text-center mt-3"><b>Josh, Liverpool</b></h6>
                </div>

                <div class="review col-4 mt-4">
                    <ul class="d-flex p-0 justify-content-center">
                        <li><img src="data/star.png" width="30"  class="m-0 star img-responsive inline-block" alt="star" /></li>
                        <li><img src="data/star.png" width="30" class="m-0 star img-responsive inline-block" alt="star" /></li>
                        <li><img src="data/star.png" width="30"  class="m-0 star img-responsive inline-block" alt="star" /></li>
                        <li><img src="data/star.png" width="30"  class="m-0 star img-responsive inline-block" alt="star" /></li>
                        <li><img src="data/star.png" width="30"  class="m-0 star img-responsive inline-block" alt="star" /></li>
                    </ul>
                    <h6 class="review_text text-center"><i>"BrainUp gave me confidence to go to university"</i></h6>
                    <h6 class="text-center mt-3"><b>Ben, Newcastle</b></h6>
                </div>

            </div>
        </div>

        <h3 class="text-center mt-5"><b>Key Supporters</b></h3>
        <div class="row d-flex justify-content-center">
            <div class="col-8">
            <img class="img-fluid mt-3" src="data/supporters.png" alt="supporters">
            </div>
        </div>
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
        <p class="text center mt-4 fs-6" style="color: white"><b>?? BrainUp 2021</b></p>
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
      <script>

    function logout(){
        window.location.href = 'general_functions.php?logout=true';
    }

</script>
</body>
</html>
