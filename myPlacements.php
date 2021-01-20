<?php
require_once ("Models/PlacementDataSet.php");
require_once ("Models/Skills.php");
require_once  ("Models/PlacementSkills.php");
require_once  ("Models/Match.php");

$view = new stdClass();
$view->pageTitle = "My Placement Advertisements";
$placements = new PlacementDataSet();
$skills = new Skills();
$placementSkill = new PlacementSkills();
$matches = new Match();

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

if (isset($_POST['findMatches']))
{
    $matchLocationSector = $matches->checkLocationSector($_POST['placementAddress'], $_POST['placementSector']);
    var_dump($matchLocationSector[0]);
    // var_dump($_POST['placementAddress']);
    // var_dump($_POST['placementSector']);

    $matchSkills = $matches->checkStudentSkills($matchLocationSector[0], $_POST['placement_id']);
    var_dump($matchSkills);

    $view->finalMatches = [];
    for ($i = 0; $i < count($matchLocationSector); $i++)
    {
        $matchSkills = $matches->checkStudentSkills($matchLocationSector[$i], $_POST['placement_id']);
        $placementRequiredSkills = $matches->getAllPlacementSkills($_POST['placement_id']);
        $skillMatches = 0;

        for ($j = 0; $j < count($matchSkills); $j++)
        {
            for ($x = 0; $x < count($placementRequiredSkills); $x++)
            {
                if ($matchSkills[$j] == $placementRequiredSkills[$x])
                {
                    $skillMatches++;
                }
            }
        }

        if ($skillMatches > 0)
        {
            array_push($view->finalMatches, $matchLocationSector[$i]);
        }
    }
    var_dump($view->finalMatches);
}

require_once ("Views/myPlacements.phtml");