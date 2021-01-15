<?php

session_start();

if (isset($_POST['logout']))
{
    unset($_SESSION['loggedIn']);
    unset($_SESSION['username']);
    unset($_SESSION['userID']);
    unset($_SESSION['typeOfUser']);

    session_destroy();
    header("location: index.php");
}
