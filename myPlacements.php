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
if (isset($_POST['showSkills'])) {
    // If placement_id hidden field is set
    if (isset($_POST['placement_id'])) {
        // Then display all placement required skills
        $view->allPlacementSkills = $placementSkill->listAllPlacementSkills($_POST['placement_id']);
        // Keep track of current page
        $_SESSION['page'] = $_POST['pageTrack'];
    }
}

// if Add required skill button is pressed
if (isset($_POST['addSkill']))
{
    $skill = $_POST['skill'];
    // If employer selected skill is not already in skill list
    if ($placementSkill->checkSkill($_POST['placement_id'], $skill[0])) {
        // Then add skill for placement
        $placementSkill->addPlacementSkills($_POST['placement_id'], $skill[0], $skill[-1]);
    }
    // Keep the track of current page
    $_SESSION['page'] = $_POST['pageTrack'];
    // header ("location: myPlacements.php");
}

if (!isset($_SESSION['page']))
{
    if (isset($_POST['pageTrack']))
    {
        $_SESSION['page'] = $_POST['pageTrack'];
    }
    else
    {
        $_SESSION['page'] = 0;
    }
}
// var_dump($_SESSION['page']);

if (isset($_POST['prePage']))
{
    if ($_SESSION['page'] > 0)
    {
        $_SESSION['page'] -= 1;
    }
    // var_dump($placements->countPlacementID());
}

if (isset($_POST['nextPage']))
{
    if ($_SESSION['page'] < ($placements->countPlacementID() - 1)) {
        $_SESSION['page'] += 1;
    }
    //var_dump($placements->countPlacementID());
}

// var_dump( $_SESSION['page']);
// var_dump( $_POST['pageTrack']);

if ( $_SESSION['page'] ==  0)
{
    $view->allPlacements = $placements->getAllPlacements($_SESSION['page'], ($_SESSION['page'] + 1));
}
else
{
    $view->allPlacements = $placements->getAllPlacements($_SESSION['page'],  $_SESSION['page']);
}

require_once ("Views/myPlacements.phtml");