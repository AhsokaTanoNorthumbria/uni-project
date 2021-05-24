<?php
require_once 'general_functions.php';
set_session();

// check if required data has been passed by the link from the email
if ((isset($_GET['confirmation']) && isset($_GET['hash']))){
    $email = filter_var($_GET['confirmation'], FILTER_SANITIZE_EMAIL);
    $hash = filter_var($_GET['hash'], FILTER_SANITIZE_SPECIAL_CHARS);

    try {
        $dbConn = getConnection();

        $verificationQuery = "SELECT verification_hash, user_email 
                        FROM users
                        WHERE user_email = :email";
        $query = $dbConn->prepare($verificationQuery);
        $query->execute(array(':email' => $email));
        $getHash = $query->fetchObject();

        if($getHash->verification_hash === $hash){

            // if reset variable is present in the link, it means that user requested a password reset, so they need to be redirected to the password reset form
            if (isset($_GET['reset'])){
                // check if the link has expired
                check_exp($email);
                $_SESSION['email'] = $email;
                header("Location: #"); // change # to the password reset page (php)
            }

            // set email verification status of the user to true
            try{
                $statusUpdate = "UPDATE users
                                SET verified = true
                                WHERE user_email = :email";
                $stQuery = $dbConn->prepare($statusUpdate);
                $stQuery->execute(array(':email' => $email));

                // redirect to the dashboard after
                header("Location: dashboard.php"); // change # to the dashboard

            } catch(Exception $e){
                $ermessage = "Failed to update email verification status";
                exceptionHandler($e, $ermessage);
            }
        }
        // if hash is not the same as one in the database - redirect the user
        else redirect();


    } catch (Exception $e) {
        $ermessage = "Failed to extract the email address and hash from the database or update the table";
        exceptionHandler($e, $ermessage);
    }

} else header("Location: home.php") // change # to the homepage
    
function check_exp($email){
    try {
        $dbConn = getConnection();

        $timeQuery = "SELECT user_email, hash_time 
                FROM users
                WHERE user_email = :email";
        $query = $dbConn->prepare($timeQuery);
        $query->execute(array(':email' => $email));
        $getTime = $query->fetchObject();

        $dbtime = strtotime($getTime->hash_time); // unix timestamp
        $time = time(); // unix timestamp
        // get hours
        // if one hour has passed after the email was sent - redirect
        if((($time - $dbtime) / 3600) >= 1){
            redirect();
        }

    } catch (Exception $e) {
        $ermessage = "Failed to extract the timestamp from the database";
        exceptionHandler($e, $ermessage);
    }
    return 0;
}

// redirect the user and show a message saying that the link is invalid or has expired (should request a new email)
function redirect(){
    $_SESSION['hash'] = false;
    header("Location: home.php"); 
}    

?>
