<?php
require_once ("Models/PlacementDataSet.php");

$view = new stdClass();
$view->pageTitle = "My Placement Advertisements";
$placements = new PlacementDataSet();

require_once ("logout.php");

$view->AllPlacements = $placements->getAllPlacements();

require_once ("Views/myPlacements.phtml");