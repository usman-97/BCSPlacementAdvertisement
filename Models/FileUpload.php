<?php
require_once ("Database.php");

/**
 * Class FileUpload
 * It handles file uploads for the website
 */
class FileUpload {

    protected $_dbInstance, $_dbHandle, $fileType;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * return type of the file
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * This allows user to upload user CV file
     * @param $username
     * @param $filetype
     * @return bool
     */
    public function cvUpload($username, $filetype)
    {
        // Target directory to upload user's CV
        $targetDir = "CVUploads/" . $username . "/";
        // If user is upload CV for first time
        if (!is_dir($targetDir))
        {
            // Then create directory for user
            mkdir("CVUploads/" . $username);
        }

        // Target file which user wants to upload
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        // Type of the file
        $this->fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Get all files from target directory
        $checkTargetDir = scandir($targetDir);
        // If target directory is not empty
        if (count($checkTargetDir) > 1)
        {
            // Then delete previous file so user can upload new file
            array_map('unlink', glob($targetDir . "*.pdf"));
        }

        // If file type is equal to set file type
        if ($this->checkFileType($filetype)) {
            // Upload file to target directory
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
                return true;
            }
            else {
                return false;
            }
        }
        else
        {
            return false;
        }

    }

    /**
     * Check file size
     * @param $size
     * @return bool
     */
    public function checkFileSize($size)
    {
        if ($_FILES['fileToUpload']['size'] < $size)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Check type of the file
     * @param $fileType
     * @return bool
     */
    private function checkFileType($fileType)
    {
        // If file extension is different than requested
        if ($this->fileType != $fileType)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Insert CV file name reference to student table
     */
    public function addFileToDatabase($userID)
    {
        // SQL query to add student user to student table
        $sqlQuery = 'UPDATE student SET cv = :filename WHERE user_id = :idUser';
        // Prepare SQL statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        // Assign values to parameters in SQL query
        $statement->bindParam(":filename", $_FILES['fileToUpload']['name'], PDO::PARAM_STR);
        $statement->bindParam(":idUser", $userID, PDO::PARAM_INT);
        // Execute PDO statement
        $statement->execute();

    }
}
