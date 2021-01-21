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
$view->matches = new Match();
$view->finalMatches = [];

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
        if (isset($_POST['storePage']))
        {
            $_SESSION['page'] = $_POST['storePage'];
        }
        else {
            $_SESSION['page'] = 0;
        }
    }
}
// var_dump($_SESSION['storePage']);

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
    if ($_SESSION['page'] < ($placements->countPlacementID($_SESSION['userID']) - 1)) {
        $_SESSION['page'] += 1;
    }
    // var_dump($placements->countPlacementID($_SESSION['userID']));
}

// var_dump( $_SESSION['page']);
// var_dump( $_POST['pageTrack']);

if ( $_SESSION['page'] ==  0)
{
    $view->allPlacements = $placements->getAllPlacements($_SESSION['userID'], $_SESSION['page'], ($_SESSION['page'] + 1));
}
else
{
    $view->allPlacements = $placements->getAllPlacements($_SESSION['userID'], $_SESSION['page'],  $_SESSION['page']);
}

if (isset($_POST['findMatches']))
{
    $matchLocationSector = $view->matches->checkLocationSector($_POST['placementAddress'], $_POST['placementSector']);
    // var_dump($matchLocationSector);
    // var_dump($_POST['placementAddress']);
    // var_dump($_POST['placementSector']);

    /*$matchSkills = $view->matches->checkStudentSkills($matchLocationSector[0], $_POST['placement_id']);
    var_dump($matchSkills);*/

    for ($i = 0; $i < count($matchLocationSector); $i++) {
        $matchSkills = $view->matches->checkStudentSkills($matchLocationSector[$i], $_POST['placement_id']);
        $placementRequiredSkills = $view->matches->getAllPlacementSkills($_POST['placement_id']);
        $skillMatches = 0;

        if ($matchSkills)
        {
            for ($j = 0; $j < count($matchSkills); $j++)
            {
                for ($x = 0; $x < count($placementRequiredSkills); $x++) {
                    if ($matchSkills[$j] == $placementRequiredSkills[$x])
                    {
                        $skillMatches++;
                    }
                }
            }
        }
        else
        {
            $view->error = "No match found";
        }

        if ($skillMatches > 0)
        {
            array_push($view->finalMatches, $matchLocationSector[$i]);
        }
        else
        {
            $view->error = "No candidate found";
        }
    }

    if (count($view->finalMatches) > 0)
    {
        $_SESSION['MatchMode'] = true;
    }

    $_SESSION['page'] = $_POST['pageTrack'];
    // var_dump($_POST['placement_id']);
}

if (count($view->finalMatches) > 0)
{
    for ($z = 0; $z < count($view->finalMatches); $z++)
    {
        $view->potentialCandidates[] = $view->matches->showCandidates($view->finalMatches[$z]);
    }
}
// var_dump($view->finalMatches);
// var_dump($view->potentialCandidates);
// var_dump($_SESSION['MatchMode']);
// var_dump(count($view->finalPotentialCandidates));

if (isset($_SESSION['candidatePage']))
{
    if (isset($_POST['storeCandidatePage']))
    {
        $_SESSION['candidatePage'] = $_POST['storeCandidatePage'];
    }
    else
    {
        $_SESSION['candidatePage'] = 0;
    }
}

if (isset($_POST['previousCandidate']))
{
    $_SESSION['page'] = $_POST['pageTrack'];
    $_SESSION['page'] = $_POST['storePage'];
    $_SESSION['candidatePage'] -= 0;
}

if (isset($_POST['previousCandidate']))
{
    $_SESSION['page'] = $_POST['pageTrack'];
    $_SESSION['page'] = $_POST['storePage'];
    $_SESSION['candidatePage'] += 0;
}

if (isset($_POST['acceptMatch']))
{
    // $_SESSION['page'] = $_POST['storePage'];
    /*if ($view->matches->checkMatch($_POST['storeCandidateID'], $_POST['storePlacementID']))
    {*/
        $view->matches->addMatch($_POST['storeCandidateID'], $_POST['storePlacementID']);
        $view->matches->sendMessage($_POST['storeCandidateID'], $_POST['storePlacementTitle']);
        header("location: viewMatches.php");
        // var_dump($_POST['storePlacementTitle']);
    // }
    /*else
    {
        $view->error = "You have already saved this match for placement";
    }*/
}

require_once ("Views/myPlacements.phtml");