<?php
require_once ("Models/PlacementDataSet.php");
require_once ("Models/Skills.php");
require_once  ("Models/PlacementSkills.php");

$view = new stdClass();
$view->pageTitle = "My Placement Advertisements";
$placements = new PlacementDataSet();
$skills = new Skills();
$placementSkill = new PlacementSkills();

require_once ("logout.php");

$view->allSkills = $skills->listPlacementSkills();

// $_SESSION['showSkills'] = true;
$view->allPlacementSkills = $placementSkill->listAllPlacementSkills($_POST['placement_id']);
var_dump($_POST['placement_id']);

if (isset($_POST['addSkill']))
{
    $skill = $_POST['skill'];
    // if ($placementSkill->checkSkill($_POST['placement_id'], $skill[0])) {
        $placementSkill->addPlacementSkills($_POST['placement_id'], $skill[0], $skill[-1]);
    // }

    // header ("location: myPlacements.php");
}

if (isset($_POST['nextPage']))
{
    if ($_SESSION['page'] != $placements->countPlacementID() - 1)
    {
        $_SESSION['page'] += 1;
    }
    var_dump($placements->countPlacementID());
}

if (isset($_POST['prePage']))
{
    if ($_SESSION['page'] != 0)
    {
        $_SESSION['page'] -= 1;
    }
}
var_dump($_SESSION['page']);

$view->allPlacements = $placements->getAllPlacements( $_SESSION['page'],  $_SESSION['page'] + 1);

require_once ("Views/myPlacements.phtml");