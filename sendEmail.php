<?php
require_once 'general_functions.php';
set_session();

// functions for sending emails for registration verification and password reset

// send first verification email right after the registration
function send_verification_email($newUser){

    $subject = 'Email Verification | BrainUp';
    // message that contains the verification link
    $message = '
    
    Hi '.$newUser['firstname'].'. 
    Thanks for signing up!
    
    To access our courses you will need to verify your email,
    you can do that by following the link bellow:
    
    http://unn-w19022158.newnumyspace.co.uk/test/emailVerification.php?confirmation='.$newUser['email'].'&hash='.$newUser['verificationHash'].'
    
    
    
    BrainUp team
            
  
    ';
    $from = 'From: BrainUp <noreply@brainup.com>' . "\r\n";
    // send the email
    mail($newUser['email'], $subject, $message, $from);
}

// resend the email on request
function resend_verification(){
    if (isset($_COOKIE)) {
        // get user id from the cookie
        $userID = $_COOKIE['logon_status'];
        $newHash = md5(rand(0, 1000));

        try {
            $dbConn = getConnection();

            // update verification hash
            $hashQuery = "UPDATE users
                        SET verification_hash = :newHash
                        WHERE user_id = :id";
            $query = $dbConn->prepare($hashQuery);
            $query->execute(array(':id' => $userID, ':newHash' => $newHash));

            // get all necessary data for the email from the table
            $emailQuery = "SELECT user_id, user_email, firstname, verification_hash
                        FROM users
                        WHERE user_id = :id";
            $query = $dbConn->prepare($emailQuery);
            $query->execute(array(':id' => $userID));
            $getEmail = $query->fetchObject();

            $newUser['email'] = $getEmail->user_email;
            $newUser['firstname'] = $getEmail->firstname;
            $newUser['verificationHash'] = $getEmail->verification_hash;
            // send the email
            send_verification_email($newUser);

        } catch (Exception $e) {
            $ermessage = "Failed to extract user data from the database for the email verification";
            exceptionHandler($e, $ermessage);

        }
    }
    else header("Location: #"); //homepage

}

// email for password reset
function password_reset_email(){

    // get email
    $reset['email'] = filter_has_var(INPUT_POST, 'email') ? $_POST['email'] : null;
    $reset['email'] = filter_var($reset['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($reset['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['validEmail'] = false;
        header("Location: #"); // change # to the registration form
    }
    try {
        $dbConn = getConnection();

        $resetQuery = "SELECT user_email
                        FROM users
                        WHERE user_email = :email";
        $query = $dbConn->prepare($resetQuery);
        $query->execute(array(':email' => $reset['email']));
        $conEmail = $query->fetchObject();

        if (!empty($conEmail->user_email)) {
            // update verification hash for the new email
            $reset['hash'] = md5(rand(0, 1000));

            $hashQuery = "UPDATE users 
                        SET verification_hash = :hash
                        WHERE user_email = :email";
            $query = $dbConn->prepare($hashQuery);
            $query->execute(array(':email' => $reset['email'], ':hash' => $reset['hash']));

            // send the email
            $subject = 'Password Reset | BrainUp';
            // message that contains the password reset link
            $message = '
    
    We have received a password reset request for ' . $reset['email'] . '. 
    
    
    Please follow the link bellow to reset your password:
    
    http://unn-w19022158.newnumyspace.co.uk/test/emailVerification.php?confirmation=' . $reset['email'] . '&hash=' . $reset['hash'] . '&reset=true
    
    
    Thank you,
    BrainUp team
            
  
    ';
            $from = 'From: BrainUp <noreply@brainup.com>' . "\r\n";

            mail($reset['email'], $subject, $message, $from);

        }

        // even if the email is not present in the database, show confirmation of sent email to the user

    } catch (Exception $e) {
        $ermessage = "Failed to extract an email from the database for the password reset";
        exceptionHandler($e, $ermessage);

    }
}

// if verification email has been requested bu the user
if(isset($_GET['verification_resend'])){
    resend_verification();
}
// if user has requested the password reset
if(isset($_GET['password_reset'])){
    password_reset_email();
}


?>