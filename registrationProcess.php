<?php
require_once 'general_functions.php';
set_session();

// function for validation of user credentials
function get_and_validate_input()
{
    // get and sanitise FIRSTNAME
    $newUser['firstname'] = filter_has_var(INPUT_POST, 'firstname') ? $_POST['firstname'] : null;
    if(empty(trim($newUser['firstname']))){
        $_SESSION['emptyFirstname'] = true;
        header("Location: #"); // change to the logon form
    }
    $newUser['firstname'] = filter_var($newUser['firstname'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    // get and sanitise SURNAME
    $newUser['surname'] = filter_has_var(INPUT_POST, 'surname') ? $_POST['surname'] : null;
    if(empty(trim($newUser['surname']))){
        $_SESSION['emptySurname'] = true;
        header("Location: #"); // change to the logon form
    }
    $newUser['surname'] = filter_var($newUser['surname'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    // get and sanitise PASSWORD
    $newUser['password'] = filter_has_var(INPUT_POST, 'password') ? $_POST['password'] : null;
    if(empty(trim($newUser['password']))){
        $_SESSION['emptyPassword'] = true;
        header("Location: #"); // change to the logon form
    }
    $newUser['password'] = filter_var($newUser['password'], FILTER_SANITIZE_SPECIAL_CHARS);
    
    // get, sanitise and validate EMAIL
    $newUser['email'] = filter_has_var(INPUT_POST, 'email') ? $_POST['email'] : null;
    if(empty(trim($newUser['email']))){
        $_SESSION['emptyEmail'] = true;
        header("Location: #"); // change to the logon form
    }
    $newUser['email'] = filter_var($newUser['email'], FILTER_SANITIZE_EMAIL);
    if(!filter_var($newUser['email'], FILTER_VALIDATE_EMAIL)){
        $_SESSION['validEmail'] = false;
        header("Location: #"); // change # to the registration form
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
            header("Location: #"); // change # to the registration form
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

     // get user id to set the cookie
     $idQuery = "SELECT user_id, user_email
                FROM users
                WHERE user_email = :email";
     $query = $dbConn->prepare($idQuery);
     $query->execute(array(':email' => $newUser['email']));
     $getID = $query->fetchObject();
     $userID = $getID -> user_id;

     set_cookie($userID);

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

    header("Location: #"); //change # to the dashboard
}

// if form has not been submitted, redirect user to the homepage
header("Location: #"); //change # to the homepage


?>
