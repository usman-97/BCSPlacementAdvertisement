<?php
require_once ("Database.php");
require_once ("StudentSkillData.php");

/**
 * Class StudentSkill
 */
class StudentSkill {
    protected $_dbHandle, $_dbInstance;

    /**
     * StudentSkill constructor.
     */
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance(); // Create Database instance
        $this->_dbHandle = $this->_dbInstance->getdbConnection(); // Establish connection to database
    }

    public function addStudentSkill($id, $skill, $level)
    {
        // SQL query to get
        $sqlQuery = "INSERT INTO student_skill VALUES (:userID, :skill_id, :skillLevel)";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":userID", $id, PDO::PARAM_INT);
        $statement->bindParam(":skill_id", $skill, PDO::PARAM_INT);
        $statement->bindParam(":skillLevel", $level, PDO::PARAM_INT);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch())
        {
            $dataSet[] = new StudentSkillData($row);
        }
        return $dataSet;
    }
}