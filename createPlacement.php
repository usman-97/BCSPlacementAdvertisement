<?php
require_once ("Models/PlacementDataSet.php");
require_once ("Models/Skills.php");

$view = new stdClass();
$view->pageTitle = "Create Placement";
$placement = new PlacementDataSet();
$skills = new Skills();
$view->allSkills = $skills->listPlacementSkills();

require_once ("logout.php");

// $view->getAllSkills = $skills->listPlacementSkills();

if (isset($_POST['createPlacement']))
{
    if (!empty($_POST['company']) && !empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['benefits']) && !empty($_POST['location']) &&
        !empty($_POST['salary']) && !empty($_POST['salaryPaid']) && !empty($_POST['startDate']) && !empty($_POST['endDate']))
    {
        $placement->createPlacement($_POST['company'], $_POST['sector'], $_POST['title'], $_POST['description'], $_POST['benefits'], $_POST['location'], $_POST['salary'], $_POST['salaryPaid'], $_POST['startDate'], $_POST['endDate'], $_SESSION['userID']);
        $_SESSION['placement_id'] = $placement->getPlacementID();
        header("location: myPlacements.php");
    }
    else
    {
        $view->error = "Please fill all fields";
    }
}

if (isset($_POST['cancel']))
{

    header("location: index.php");
}

if (isset($_POST['showSkills']))
{
    $_SESSION['addSkills'] = true;
}

require_once ("Views/createPlacement.phtml");
