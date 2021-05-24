<?php
require_once 'general_functions.php';
set_session();

// function for validation of user credentials
function get_and_validate_input()
{
    // get and sanitise FULL NAME
    $newUser['fullName'] = filter_has_var(INPUT_POST, 'fullName') ? $_POST['fullName'] : null;
    if(empty(trim($newUser['fullName']))){
        $_SESSION['emptyName'] = true;
        header("Location: home.php");
    }
    $newUser['fullName'] = filter_var($newUser['fullName'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $fullName = explode(" ", $newUser['fullName']);

    // get FIRSTNAME
    $newUser['firstname'] = $fullName[0];
    // get SURNAME
    $newUser['surname'] = $fullName[1];

    // get DOB
    $day = filter_has_var(INPUT_POST, 'day') ? $_POST['day'] : null;
    $month = filter_has_var(INPUT_POST, 'month') ? $_POST['month'] : null;
    $year = filter_has_var(INPUT_POST, 'year') ? $_POST['year'] : null;
    $newUser['dob'] = "$year-$month-$day";

    // get and sanitise PASSWORD
    $newUser['password'] = filter_has_var(INPUT_POST, 'password') ? $_POST['password'] : null;
    if(empty(trim($newUser['password']))){
        $_SESSION['emptyPassword'] = true;
        header("Location: home.php");
    }
    $newUser['password'] = filter_var($newUser['password'], FILTER_SANITIZE_SPECIAL_CHARS);
    
    // get, sanitise and validate EMAIL
    $newUser['email'] = filter_has_var(INPUT_POST, 'email') ? $_POST['email'] : null;
    if(empty(trim($newUser['email']))){
        $_SESSION['emptyEmail'] = true;
        header("Location: home.php");
    }
    $newUser['email'] = filter_var($newUser['email'], FILTER_SANITIZE_EMAIL);
    if(!filter_var($newUser['email'], FILTER_VALIDATE_EMAIL)){
        $_SESSION['validEmail'] = false;
        header("Location: home.php");
    }
    // check if user is registered already
    $email = $newUser['email'];
    registration_check($email);
    // continue the process if email is not present in the database
    // create a random hash for email verification
    $newUser['verificationHash'] = md5(rand(0, 1000));
    return array($newUser);

}// END get_and_validate_input()

// function for checking if user is in the database already
function registration_check($email){
    try {
        $dbConn = getConnection();

        $emailQuery = "SELECT user_id 
                        FROM users
                        WHERE user_email = :email";
        $query = $dbConn->prepare($emailQuery);
        $query->execute(array(':email' => $email));
        $getUserID = $query->fetchObject();

        // check if user id has been fetched and is not empty
        if (!empty($getUserID)) {
            // redirect the user back to the registration form if email is present in the database
            $_SESSION['isRegistered'] = true;
            header("Location: home.php"); 
            die;
        }

        } catch (Exception $e) {
            $ermessage = "Failed to extract the email address from the database";
            exceptionHandler($e, $ermessage);
        }
        return 0;

}// END registration_check()

// function for adding new user to the database
function add_new_user($newUser){
 try{
     $dbConn = getConnection();

     $newUserQuery = "INSERT INTO users (user_email, firstname, surname, password_hash, verification_hash)
                        VALUES (:email, :firstname, :surname, :password, :hash)";
     $query = $dbConn->prepare($newUserQuery);
     $query->execute(array(':email' => $newUser['email'], ':firstname' => $newUser['firstname'], ':surname' => $newUser['surname'], ':password' => password_hash($newUser['password'], PASSWORD_DEFAULT), ':hash' => $newUser['verificationHash']));

     // get user id and first name to set the cookie
     $idQuery = "SELECT user_id, user_email
                FROM users
                WHERE user_email = :email";
     $query = $dbConn->prepare($idQuery);
     $query->execute(array(':email' => $newUser['email']));
     $getID = $query->fetchObject();
     $user['id'] = $getID -> user_id;
     $user['firstname'] = $newUser['firstname'];
     // hash user id
     $user['hash'] = md5($user['id']);

     // add user id hash to the database
     try{
         $newUserQuery = "INSERT INTO users (user_id_hash)
                        VALUES (:hash)";
         $query = $dbConn->prepare($newUserQuery);
         $query->execute(array(':hash' => $user['hash']));

     } catch(Exception $e){
         $ermessage = "Failed to add the user ID hash to the database";
         exceptionHandler($e, $ermessage);
     }

     set_cookie($user);

 } catch(Exception $e){
     $ermessage = "Failed to add new user to the database or extract user ID";
     exceptionHandler($e, $ermessage);
 }
}// END add_new_user()


// check if form has been submitted and page has not been accessed by accident and execute the process of registering new user
if(!empty($_POST)) {
    list($newUser) = get_and_validate_input();
    add_new_user($newUser);
    require_once 'sendEmail.php';
    send_verification_email($newUser);

    header("Location: dashboard.php"); //change # to the dashboard
}

// if form has not been submitted, redirect user to the homepage
else header("Location: home.php"); //change # to the homepage


?>
