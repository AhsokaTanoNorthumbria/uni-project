<?php
require_once 'general_functions.php';
set_session();
?>
<!DOCTYPE html>
<html lang="en">
<?php

	//if(!isset($_SESSION['payment-loggedin'])){
	//check a course ID is set
	$courseID = filter_var($_GET['courseID'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$payment = filter_var($_GET['payment'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(!(empty($courseID) || empty($payment))){	
		try{
			//make connection with database
			$dbConn = getConnection();
			//sql statement with placeholders ready to be prepared
			$querySQL = "SELECT * from courses WHERE course_id =:courseID";
			//prepares the SQL statement and stores it in a new variable
			$statement = $dbConn->prepare($querySQL);
			//executes the SQL statement, replacing the course placeholder with the actual course selected by the user
			$statement->execute(array(':courseID'=> $courseID));
			
			//hold the data for the course in an object
			$course = $statement->fetchObject();
			
			//if course with the ID does not exist, redirect back to the home page
			if(!($course)){
				 header("Location: home.php");
			}
		}
		catch (Exception $e) {
            $m = "Failed to add new course to the active courses table";
            exceptionHandler($e, $m);
		}
	}
	else{
		//no course ID or payment hash in URL, so redirect back to the home page
		header("Location: home.php");
		}
		
		
?>
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
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
        <a class="navbar-brand mx-4 pb-3" href="home.php"> <img src="data/logo.png" width="120" height="40" class="d-inline-block" alt="logo of BrainUp"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-5 mb-2 mb-lg-0">
                <li class="nav-item"> <a class="nav-link" href="home.php">Home</a> </li>
                <li class="nav-item "> <a class="nav-link" href="courses.php">Courses</a> </li>
                <li class="nav-item "> <a class="nav-link" href="#">Vacancies</a> </li>
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
                                    <input type="email" name="email" class="form-control" id="loginInputEmail1" aria-describedby="emailHelp">
                                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="loginInputPassword1" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="loginInputPassword1">
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember">
                                    <label class="form-check-label" for="remember">Remember me </label>
                                </div>
                                <div class="mb-2">
                                    <button id="loginSubmit" name="submit" type="submit" class="btn btn-primary">Sign In</button>
                                </div>
                                <div class="d-flex justify-content-center mb-3">
                                    <a href="#" class="link-primary">Forgot your password?</a>
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
                                    <button id="signUpSubmit" name="submit" type="submit" class="btn btn-primary">Sign Up</button>
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
		<?php
		
			//if login-status has been created - user has already logged in, and if payment hash is not empty (preventing unauthorised attacks)
			if(!(empty($_COOKIE['logon_status']) || empty($payment) || $payment == false)){
				
				//get username hash from the user cookie
				$userCookie = $_COOKIE['hash'];
				//set user logged in to true
				$loggedIn = true;
			}
			else{
				//user is not logged in
				$loggedIn = false;
			}
			
			//check user is logged in and payment hash is the same as the hash in $_COOKIE['hash'] - to help prevent backdoor attacks
			if($loggedIn && ($payment === $userCookie)){
				require 'payment-loggedin.php';
			}
			else{
				//if not logged in or incorrect user hash, user is displayed an error with the option to log in
				require 'payment-notloggedin.php';
			}
			
		?>

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
<footer class="mt-5">

</footer>
	<script>

    function logout(){
        window.location.href = 'general_functions.php?logout=true';
    }

</script>
</body>
</html>
