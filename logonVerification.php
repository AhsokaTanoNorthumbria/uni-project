<?php
require_once 'general_functions.php';
set_session();

//get users input and validate/sanitise it

// EMAIL
$user['email'] = filter_has_var(INPUT_POST, 'email') ? $_POST['email'] : null;
$user['email'] = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
if(!filter_var($user['email'], FILTER_VALIDATE_EMAIL)){
    // session variable for showing a message on the logon form about invalid email
    $_SESSION['validEmail'] = false;
    header("Location: #"); // change # to the registration form
}

// PASSWORD
$user['password'] = filter_has_var(INPUT_POST, 'password') ? $_POST['password'] : null;
$user['password'] = filter_var($user['password'], FILTER_SANITIZE_SPECIAL_CHARS);

// verify user credentials
try {
    $dbConn = getConnection();

    $userQuery = "SELECT user_id, user_email, password_hash
                FROM users
                WHERE user_email = :email";
    $query = $dbConn->prepare($userQuery);
    $query->execute(array(':email' => $user['email']));
    $getUser = $query->fetchObject();

    //if there is such a user in the database verify password
    if (!empty($getUser)) {
        $passwordHash = $getUser->password_hash;
        if (password_verify($user['password'], $passwordHash)) {
            //if verification passed, set the cookie and redirect to the page user came
            $userID = $getUser -> user_id;
            set_cookie($userID);
            $referer = $_SERVER['HTTP_REFERER'];
            // if referer is empty or is set to the homepage, redirect to the dashboard
            if(empty($referer) or $referer == '#'){ // change # to the homepage link
                header("Location: #"); // change # to the dashboard
            }
            // else, redirect to the previous page
            else header("Location: $referer");

        } //if password is incorrect, redirect to the the form
        else {
            // set the session variable to show a message on the logon form about incorrect provided data
            $_SESSION['password'] = false;
            header("Location: #"); // change to the logon form
        }

    } //if the given email does not exist in the database, redirect to the form
    else {
        // set the session variable to show a message on the logon form that user is not registered
        $_SESSION['exists'] = false;
        header("Location: #"); // change to the logon form
    }

} catch (Exception $e) {
    $m = "Problem with extracting user data from the database";
    exceptionHandler($e, $m);

}
?>

