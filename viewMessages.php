<?php
require_once ("Models/Match.php");

$view = new stdClass();
$view->pageTitle = "Messages";
$messages = new Match();

require_once ("logout.php");

$view->allMessages = $messages->getMessages($_SESSION['userID']);
if  (!$messages->getMessages($_SESSION['userID']))
{
    $view->error = "No new message found";
}

require_once ("Views/viewMessages.phtml");
