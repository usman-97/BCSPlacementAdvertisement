<?php
require_once ("Models/FileUpload.php");
require_once ("Models/User.php");
require_once ("Models/Skills.php");
require_once ("Models/StudentSkill.php");
require_once ("logout.php");

$view = new stdClass();
$view->pageTitle = "My Profile";
$cv = new FileUpload();
$user = new User();
$skills = new Skills();
$studentSkill = new StudentSkill();

$view->showSkills = $skills->listPlacementSkills();
// var_dump($view->selectSkills);

$view->listSkills = $studentSkill->showStudentSkills($_SESSION['userID']);
// var_dump($view->listSkills);
if (!$view->listSkills)
{
    $view->msg = "Add Skills";
}

// If user has pressed cvUpload button
if (isset($_POST['cvUpload']))
{
    // If user doesn't choose any file
    if (!$_FILES['fileToUpload']['name'] == "") {
        // If file size is greater than 250mb
        if ($cv->checkFileSize(2500000)) {
            // If user uploaded cv document is in pdf format
            if ($cv->cvUpload($_SESSION['username'], "pdf")) {
                // Add student cv file reference to database
                $cv->addFileToDatabase($_SESSION['userID']);
                // Confirm user that file is uploaded
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

if (isset($_POST['addStudentSkills']))
{
    $selectedSkill = $_POST['studentSkill'];
    if ($studentSkill->checkSkill($_SESSION['userID'],  $selectedSkill[0]))
    {
        $view->selectSkills = $studentSkill->addStudentSkill($_SESSION['userID'], $selectedSkill[0], $selectedSkill[-1]);
        header ("location: studentProfile.php");
    }
    // var_dump($_SESSION['userID']);
}

require_once ("Views/studentProfile.phtml");
