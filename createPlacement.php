<?php
require_once ("Models/PlacementDataSet.php");

$view = new stdClass();
$view->pageTitle = "Create Placement";
$placement = new PlacementDataSet();

require_once ("logout.php");

// $view->getAllSkills = $skills->listPlacementSkills();

if (isset($_POST['createPlacement']))
{
    if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['benefits']) && !empty($_POST['salary']) &&
        !empty($_POST['salaryPaid']) && !empty($_POST['startDate']) && !empty($_POST['endDate']))
    {
        $placement->createPlacement($_POST['title'], $_POST['description'], $_POST['benefits'], $_POST['salary'], $_POST['salaryPaid'], $_POST['startDate'], $_POST['endDate']);
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

require_once ("Views/createPlacement.phtml");
