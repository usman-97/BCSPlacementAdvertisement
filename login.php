<?php

require_once ("Models/User.php");
require_once ("Models/ReCaptcha.php");

$view = new stdClass();
$view->pageTitle = "Sign in"; // Title of the page
$user = new User(); // Instance of User class
$reCaptcha = new ReCaptcha();
$view->finalReCaptcha = $reCaptcha->generateReCaptcha();

require_once ("logout.php");

// If Sign in button is pressed
if (isset($_POST['login']))
{
    // Check if email and password fields are not empty
    if (!empty(trim($_POST['userEmail'])) && !empty(trim($_POST['pwd'])))
    {
        $user->setEmail($_POST['userEmail']); // Set email field for User
        $user->setPassword($_POST['pwd']); // Set password field for User

        // Check if email exist or match in database
        if ($user->checkEmail()) {
            if ($_POST['reCaptcha'] == $_POST['storeReCaptcha']) {
                // If user password match with password in database
                if ($user->verifyUser()) {
                    // session_start(); // start session

                    $_SESSION['loggedIn'] = true; // start loggedIn session
                    $_SESSION['username'] = $user->getFullName(); // get full name of user
                    $_SESSION['userID'] = $user->getUserID(); // get user id from database
                    $_SESSION['typeOfUser'] = $user->getUserType(); // get type of user
                    $_SESSION['email'] = $user->getEmail(); // get type of user
                    $_SESSION['phone'] = $user->getPhoneNumber(); // get type of user
                    $_SESSION['address'] = $user->getAddress(); // get type of user
                    $_SESSION['timeout'] = time(); // get the time when user logged in

                    header("location: index.php");
                }
                else {
                    $view->error = "Invalid password";
                }
            }
            else {
                $view->error = "Incorrect reCaptcha";
            }
        }
        else {
            $view->error = "Invalid email";
        }
    }
    else
    {
        $view->error = "Please fill type email/password";
    }
}

require_once ("Views/login.phtml");
