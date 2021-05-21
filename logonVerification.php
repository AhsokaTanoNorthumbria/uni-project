<?php
require_once 'general_functions.php';
set_session();


// get a domain name and location of the website (directories)
function cal_home(){
    $referer = $_SERVER['HTTP_REFERER'];
    $array = explode('/', $referer);
    // get an index of the last element of the array
    $index = (count($array))-1;
    // remove the last element
    unset($array[$index]);
    // join all the array elemets back into one string
    $referer = implode('/', $array);

    return $referer.'/home.html';
}

function cal_payment($ind, $hash){
    if($ind === 'check'){
        $referer = $_SERVER['HTTP_REFERER'];
        $array = explode('&', $referer);
        $index = (count($array))-1;
        echo $array[$index];
        return $array[$index];
    }
    if($ind === 'get'){
        $referer = $_SERVER['HTTP_REFERER'];
        $array = explode('&', $referer);
        $index = (count($array))-1;
        unset($array[$index]);
        $referer = implode('', $array);

        return $referer.'&payment='.$hash;
    }
}

if(isset($_POST['submit'])) {
    //get users input and validate/sanitise it

    // EMAIL
    $user['email'] = filter_has_var(INPUT_POST, 'email') ? $_POST['email'] : null;
    if(empty(trim($user['email']))){
        $_SESSION['emptyEmail'] = true;
        header("Location: home.html"); // change to the logon form
    }
    $user['email'] = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
    if(!filter_var($user['email'], FILTER_VALIDATE_EMAIL)){
        // session variable for showing a message on the logon form about invalid email
        $_SESSION['validEmail'] = false;
        header("Location: home.html"); // change # to the registration form
    }

    // PASSWORD
    $user['password'] = filter_has_var(INPUT_POST, 'password') ? $_POST['password'] : null;
        if(empty(trim($user['password']))){
            $_SESSION['emptyPassword'] = true;
            header("Location: home.html"); // change to the logon form
        }
    $user['password'] = filter_var($user['password'], FILTER_SANITIZE_SPECIAL_CHARS);

    // verify user credentials
    try {
        $dbConn = getConnection();

        $userQuery = "SELECT user_id, user_email, password_hash, firstname
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
                $user['id'] = $getUser -> user_id;
                $user['hash'] = md5($user['id']);
                $user['firstname'] = $getUser -> firstname;
                $hash = $user['hash'];
                set_cookie($user);
                
                $referer = $_SERVER['HTTP_REFERER'];
                $ind = 'check';
                $payment = cal_payment($ind, $hash);
                $home = cal_home();
                
                // if referer is empty or is set to the homepage, redirect to the dashboard
                if(empty($referer) or $referer == $home){ // change # to the homepage link
                    header("Location: dashboard.php"); // change # to the dashboard
                }
                // if referrer is the payment page
                if($payment === "payment=false"){
                    $ind = 'get';
                    $paymentURL = cal_payment($ind, $hash);
                    header("Location: $paymentURL");
                    die;
                }
                // else, redirect to the previous page
                else header("Location: $referer");

            } //if password is incorrect, redirect to the the form
            else {
                // set the session variable to show a message on the logon form about incorrect provided data
                $_SESSION['password'] = false;
                header("Location: home.html"); // change to the logon form
            }

        } //if the given email does not exist in the database, redirect to the form
        else {
            // set the session variable to show a message on the logon form that user is not registered
            $_SESSION['exists'] = false;
            header("Location: home.html"); // change to the logon form
        }

    } catch (Exception $e) {
        $m = "Problem with extracting user data from the database";
        exceptionHandler($e, $m);

    }
}
// accidental access
else header("Location: home.html"); // change to the homepage
?>

