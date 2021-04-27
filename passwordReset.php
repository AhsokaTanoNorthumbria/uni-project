<?php
require_once 'general_functions.php';
set_session();

if(isset($_SESSION['email'])){
    // get the email
    $email = $_SESSION['email'];
    // get the password
    $newPassword = filter_has_var(INPUT_POST, 'password') ? $_POST['password'] : null;
    if(empty(trim($newPassword))){
        $_SESSION['emptyNewPassword'] = true;
        header("Location: #"); // change to the password reset form
    }
    $newPassword = filter_var($newPassword, FILTER_SANITIZE_SPECIAL_CHARS);
    // update the password
    try{
        $dbConn = getConnection();

        $newPasswordQuery = "UPDATE users
                            SET password_hash = :newPassword
                            WHERE user_email = :email";
        $query = $dbConn->prepare($newPasswordQuery);
        $query->execute(array(':email' => $email, ':newPassword' => password_hash($newPassword, PASSWORD_DEFAULT)));

        // unset the session to prevent the second access
        session_unset();
        // set the session variable to show a message about successful password reset on the logon form
        $_SESSION['successfulPasswordReset'] = true;
        header("Location: #");// change to the logon form

    } catch(Exception $e){
        $ermessage = "Failed to update password";
        exceptionHandler($e, $ermessage);
    }

}
// for accidental access
else header("Location: #"); // change to the homepage

?>
