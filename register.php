<?php
require_once ("Models/User.php");

$view = new stdClass();
$view->pageTitle = "Register"; // Title of the page
$user = new User(); // User class instance
$view->error = "";
$view->typeOfUser = "";

// If sign up button is pressed
if (isset($_POST['register'])) {
    if (empty(trim($_POST['username'])))
    {
        // If fields in form are not empty
        if (!empty(trim($_POST['newFullName'])) && !empty(trim($_POST['email'])) && !empty(trim($_POST['newPwd'])) &&
            !empty(trim($_POST['phone_number'])) && !empty(trim($_POST['address']))) {
            if (!empty($_POST['userType'])) {
                if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    if (strlen($_POST['newPwd']) >= 8) {
                        $user->setEmail($_POST['email']); // Sets email field for user
                        $user->setPassword($_POST['newPwd']); // Sets password field for user
                        $user->setUserType($_POST['userType']); // Sets userType field for user
                        // If user email doesn't exist in database
                        if (!$user->checkEmail()) {
                            if ($_POST['newPwd'] == $_POST['confirmPassword']) {
                                if ($_POST['userType'] == "Student") {
                                    if (preg_match('/ac.uk$/', $_POST['email'])) {
                                        // Then register new user
                                        $user->register($_POST['newFullName'], $_POST['phone_number'], $_POST['address']);
                                        $user->addStudent();
                                        header("location: login.php");
                                    } else {
                                        $view->error = "Please use your College/University email to register";
                                    }
                                }
                                if ($_POST['userType'] == "Employer") {
                                    // Then register new user
                                    $user->register($_POST['newFullName'], $_POST['phone_number'], $_POST['address']);
                                    $user->addEmployer();
                                    header("location: login.php");
                                }
                                /*else
                                {
                                    $view->error = "Please choose between Student or employer";
                                }*/
                                // echo "Created";
                            } else {
                                $view->error = "Password did not match";
                            }
                        } else {
                            $view->error = "This email is already taken";
                        }
                    } else {
                        $view->error = "Your password should be greater than 8 characters";
                    }
                } else {
                    $view->error = "Invalid Email";
                }
            }
            else
            {
                $view->error = "Please select if you are an employer or a student";
            }
        } else {
            $view->error = "Please fill all fields";
        }
    }
    else
    {
        die("Oops...You lost the connection with database");
    }
}

require_once ("Views/register.phtml");