<?php
require_once ("Models/User.php");

$view = new stdClass();
$view->pageTitle = "Register"; // Title of the page
$user = new User(); // User class instance
$view->error = "";
$view->typeOfUser = "";

// If sign up button is pressed
if (isset($_POST['register']))
{
    // If fields in form are not empty
    if (!empty(trim($_POST['newFullName'])) && !empty(trim($_POST['email'])) && !empty(trim($_POST['newPwd'])) &&
        !empty(trim($_POST['phone_number'])) && !empty(trim($_POST['address'])))
    {
        $user->setEmail($_POST['email']); // Sets email field for user
        $user->setPassword($_POST['newPwd']); // Sets password field for user
        $user->setUserType($_POST['userType']); // Sets userType field for user
        // If user email doesn't exist in database
        if (!$user->checkEmail())
        {
            if ($_POST['newPwd'] === $_POST['confirmPassword'])
            {
                // Then register new user
                $user->register($_POST['newFullName'], $_POST['phone_number'], $_POST['address']);
                header ("location: login.php");
            }
            else
            {
                $view->error = "Password doesn't match";
            }
        }
        else
        {
            $view->error = "This email is already taken";
        }
    }
    else
    {
        $view->error = "Please fill all fields";
    }
}

require_once ("Views/register.phtml");