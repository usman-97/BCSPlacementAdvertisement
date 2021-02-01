<?php
require_once ("Models/ChangeSkillID.php");

$view = new stdClass();
$view->pageTitle = "Placement Advertisements";
$changeID = new ChangeSkillID();

require_once ("logout.php");

require_once ("Views/index.phtml");