<?php
require_once ("Models/FileUpload.php");
require_once ("Models/User.php");
require_once ("Models/StudentSkill.php");
require_once ("logout.php");

$view = new stdClass();
$view->pageTitle = "My Profile";
$cv = new FileUpload();
$user = new User();
$studentSkill = new StudentSkill();

$view->selectSkills = $studentSkill->addStudentSkill($_SESSION['userID']);
var_dump($view->selectSkills);

// $view->details = $user->getUserData($_SESSION['userID']);

if (isset($_POST['cvUpload']))
{
    if (!$_FILES['fileToUpload']['name'] == "") {
        if ($cv->checkFileSize(2500000)) {
            if ($cv->cvUpload($_SESSION['username'], "pdf")) {
                $cv->addFileToDatabase($_SESSION['userID']);
                $view->error = "The file" . htmlspecialchars(basename($_FILES['fileToUpload']['name'])) . " has been uploaded";
            } else {
                $view->error = "You can only upload .pdf format file";
            }
        } else {
            $view->error = "File size too large to upload";
        }
    } else {
        $view->error = "Please Select a file to upload";
    }
    // var_dump(basename($_FILES['fileToUpload']));
}

require_once ("Views/studentProfile.phtml");
