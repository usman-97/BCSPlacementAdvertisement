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

        }
    }
    else
    {
        $view->error = "File";
    }
}

require_once ("Views/studentProfile.phtml");
