<?php
require_once ("Models/PlacementDataSet.php");

$view = new stdClass();
$view->pageTitle = "Placement Advertisements";

require_once ("logout.php");

$viewAllPlacements = new PlacementDataSet();

$totalRecords = $viewAllPlacements->countPlacementID();
$totalPages = $totalRecords / 10;

if (!isset($_SESSION['page']))
{
    $_SESSION['page'] = 0;
}

if (isset($_POST['nextPage']))
{
    if ($_SESSION['page'] < $totalPages)
    {
        if ($totalPages - $_SESSION['page'] > $totalRecords)
        {
            $_SESSION['page'] += 10;
        }
    }
    // var_dump($totalRecords);
}

if (isset($_POST['prePage']))
{
    if ($_SESSION['page'] != 0)
    {
        $_SESSION['page'] -= 10;
    }
}

$view->allPlacements = $viewAllPlacements->getAllPlacements($_SESSION['page'], $_SESSION['page'] + 10);

require_once ("Views/viewPlacements.phtml");