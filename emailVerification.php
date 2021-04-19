<?php
require_once 'general_functions.php';
set_session();

// check if required data has been passed by the link from the email
if ((isset($_GET['confirmation']) && isset($_GET['hash']))){
    $email = $_GET['confirmation'];
    $hash = $_GET['hash'];

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
                header("Location: #"); // change # to the dashboard

            } catch(Exception $e){
                $ermessage = "Failed to update email verification status";
                exceptionHandler($e, $ermessage);
            }
        }
        // if hash is not the same as one in the database, show this message (or do something else)
        else echo "<p><strong>A problem has occurred. Please try <a href='sendEmail.php?verification_resend=true'>requesting</a> a new verification email.</strong></p>";


    } catch (Exception $e) {
        $ermessage = "Failed to extract the email address and hash from the database or update the table";
        exceptionHandler($e, $ermessage);
    }

} else header("Location: #") // change # to the homepage

?>
