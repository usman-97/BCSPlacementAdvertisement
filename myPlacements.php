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

$view->allPlacements = $placements->getAllPlacements();
$view->allSkills = $skills->listPlacementSkills();



if (isset($_POST['addSkill']))
{
    $skill = $_POST['skill'];
    $placementSkill->addPlacementSkills($_POST['placement_id'], $skill[0], $skill[-1]);
}

require_once ("Views/myPlacements.phtml");