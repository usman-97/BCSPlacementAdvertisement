<?php
require_once ("Models/ChangeSkillID.php");

$view = new stdClass();
$view->pageTitle = "BCS";
$changeID = new ChangeSkillID();

require_once ("logout.php");

require_once ("Views/index.phtml");