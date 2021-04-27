<?php
require_once 'general_functions.php';
set_session();

if(!empty($_POST['submit'])){
    // get user id for the database query
    $userID = $_COOKIE['logon_status'];

    // get and sanitise the old password
    $oldPassword = filter_has_var(INPUT_POST, 'old_password') ? $_POST['old_password'] : null;
    if(empty(trim($oldPassword))){
        $_SESSION['emptyOldPassword'] = true;
        header("Location: #"); // change to the password change form
    }
    $oldPassword = filter_var($oldPassword, FILTER_SANITIZE_SPECIAL_CHARS);

    // get and sanitize the new password
    $newPassword = filter_has_var(INPUT_POST, 'new_password') ? $_POST['new_password'] : null;
    if(empty(trim($newPassword))){
        $_SESSION['emptyNewPassword'] = true;
        header("Location: #"); // change to the password change form
    }
    $newPassword = filter_var($newPassword, FILTER_SANITIZE_SPECIAL_CHARS);

    try{
        // verify the old password
        $dbConn = getConnection();

        $oldQuery = "SELECT user_id, password_hash
                        FROM users
                        WHERE user_id = :id";
        $query = $dbConn->prepare($oldQuery);
        $query->execute(array(":id" => $userID));
        $old = $query -> fetchObject();

        // if entered old password is correct, update the password
        if(password_verify($oldPassword, $old -> password_hash)){

            try{
                $newQuery = "UPDATE users
                                SET password_hash = :newPassword
                                WHERE user_id = :id";
                $query = $dbConn->prepare($newQuery);
                $query->execute(array(":id" => $userID, ":newPassword" => password_hash($newPassword, PASSWORD_DEFAULT)));

                // redirect to the form (or anywhere else) and show a message for successful password change
                $_SESSION['successfulPasswordChange'] = true;
                header("Location: #");
            }
            catch (Exception $e) {
                $m = "Failed to update the password";
                exceptionHandler($e, $m);
            }
        }
        // if old password is incorrect redirect back to the form
        else {
            $_SESSION['oldPasswordIncorrect'] = true;
            header("Location: #"); // change to the password change form
        }

    } catch (Exception $e) {
        $m = "Failed to extract the old password from the database";
        exceptionHandler($e, $m);

    }
}
// accidental access
else header("Location: #");
?>