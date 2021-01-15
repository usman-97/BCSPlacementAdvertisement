<?php

/**
 * Class FileUpload
 * It handles file uploads for the website
 */
class FileUpload {

    protected $fileType;

    public function __construct()
    {

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
     */
    public function cvUpload($username)
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

        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile))
        {
            return true;
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
        if ($_FILES['fileToUpload']['size'] > $size)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Check type of the file
     * @param $fileType
     * @return bool
     */
    public function checkFileType($fileType)
    {
        // If file extension is not pdf
        if ($this->fileType != $fileType)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}
