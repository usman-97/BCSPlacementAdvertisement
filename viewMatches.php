<?php
require_once ("Models/Match.php");

$view = new stdClass();
$view->pageTitle = "Saved Matches";
$matches = new Match();

require_once ("logout.php");

$view->listMatches = $matches->getAllMatches($_SESSION['userID']);

require_once ("Views/viewMatches.phtml");
