<?php
require_once ("Models/PlacementDataSet.php");
require_once ("Models/Skills.php");

$view = new stdClass();
$view->pageTitle = "My Placement Advertisements";
$placements = new PlacementDataSet();
$skills = new Skills();

require_once ("logout.php");

$view->allPlacements = $placements->getAllPlacements();
$view->allSkills = $skills->listPlacementSkills();

if (isset($_POST['addSkill']))
{
    $skill = $_POST['skill'];
    var_dump($skill[-1]);
}

require_once ("Views/myPlacements.phtml");