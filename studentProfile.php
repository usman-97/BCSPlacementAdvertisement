<?php
require_once ("Models/FileUpload.php");
require_once ("Models/User.php");
require_once ("Models/Skills.php");
require_once ("Models/StudentSkill.php");
require_once ("Models/Student.php");
require_once ("logout.php");

$view = new stdClass();
$view->pageTitle = "My Profile";
$cv = new FileUpload();
$user = new User();
$skills = new Skills();
$studentSkill = new StudentSkill();
$student = new Student();
$view->showSector = $student->getSector($_SESSION['userID']);

$view->showSkills = $skills->listPlacementSkills();
// var_dump($view->selectSkills);

$view->listSkills = $studentSkill->showStudentSkills($_SESSION['userID']);
// var_dump($view->listSkills);

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
    else
    {
        $view->error = "You have already added this skill";
    }
    // var_dump($_SESSION['userID']);
}

if (isset($_POST['removeSkill']))
{
    if (isset($_POST['skill_id']))
    {
        $studentSkill->removeSkill($_SESSION['userID'], $_POST['skill_id']);
        header ("location: studentProfile.php");

    }
}

if (isset($_POST['addSector']))
{
    $student->addSector($_SESSION['userID'], $_POST['studentSector']);
    header ("location: studentProfile.php");
}

if (isset($_POST['changeDetails']))
{
    $_SESSION['changeStudentDetails'] = true;
}

if (isset($_POST['updateDetails']))
{
    if (!empty(trim($_POST['updatePhoneNumber'])))
    {
        $user->updatePhoneNumber($_SESSION['userID'], $_POST['updatePhoneNumber']);
    }

    if (!empty(trim($_POST['updateAddress'])))
    {
        $user->updateAddress($_SESSION['userID'], $_POST['updateAddress']);
    }

    unset($_SESSION['changeStudentDetails']);
    var_dump($_POST['updatePhoneNumber']);
    var_dump($_POST['updateAddress']);
    header("location: studentProfile.php");
}

// var_dump($_SESSION['changeStudentDetails']);

require_once ("Views/studentProfile.phtml");
