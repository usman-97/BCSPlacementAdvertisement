<?php
require_once ("Models/FileUpload.php");
require_once ("logout.php");

$view = new stdClass();
$view->pageTitle = "My Profile";
$cv = new FileUpload();

if (isset($_POST['cvUpload']))
{
    if ($cv->checkFileSize(5000000))
    {
        if ($cv->checkFileType("pdf"))
        {
            $cv->cvUpload($_SESSION['username']);
        }
        else
        {
            $view->error= "File size too large to upload";
        }
    }
    else
    {
        $view->error = "File size too large to upload";
    }
}

require_once ("Views/studentProfile.phtml");
