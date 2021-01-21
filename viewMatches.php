<?php
require_once ("Models/Match.php");

$view = new stdClass();
$view->pageTitle = "Saved Student Profiles";
$matches = new Match();

require_once ("logout.php");

$view->listMatches = $matches->getAllMatches($_SESSION['userID']);

if (isset($_POST['previewCV']))
{
    $view->filename = $matches->getMatchFile($_POST['user_id']);
    $file = "CVUploads/" . $_POST['candidateFullName'] ."/";
    // var_dump($file);
    // var_dump($_POST['user_id']);
    if (!$file)
    {
        $view->error = "This candidate has not uploaded their CV yet.";
    }
    else
    {
        /*header('Content-type: application.pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize( $file));
        header('Accept-Ranges: bytes');
        @readfile($file);*/

        /*exec("\\bin\\convert\\" . $file . $filename);
        print ('<img src="' . $file . $filename . '.png"');*/
    }
}

require_once ("Views/viewMatches.phtml");
