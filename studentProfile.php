<?php
require_once ("Models/FileUpload.php");
require_once ("logout.php");

$view = new stdClass();
$view->pageTitle = "My Profile";
$cv = new FileUpload();

if (isset($_POST['cvUpload']))
{
    if (!$_FILES['fileToUpload']['name'] == "") {
        if ($cv->checkFileSize(2500000)) {
            $cv->cvUpload($_SESSION['username'], "pdf");
            $cv->addFileToDatabase($_SESSION['userID']);
            $view->error = "The file" . htmlspecialchars(basename($_FILES['fileToUpload']['name'])) . " has been uploaded";
        }
        else {
            $view->error = "File size too large to upload";
        }
    }
    else
    {
        $view->error = "Please Select a file to upload";
    }
}

require_once ("Views/studentProfile.phtml");
