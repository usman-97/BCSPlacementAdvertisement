<?php
require_once ("Models/Message.php");

$view = new stdClass();
$view->pageTitle = "Messages";
$messages = new Message();

require_once ("logout.php");

$view->allMessages = $messages->getMessages($_SESSION['userID']);
if  (!$messages->getMessages($_SESSION['userID']))
{
    $view->error = "No new message found";
}

if (isset($_POST['removeMessage']))
{
    $messages->deleteMessage($_POST['messageID']);
    header("location: viewMessages.php");
}

require_once ("Views/viewMessages.phtml");
