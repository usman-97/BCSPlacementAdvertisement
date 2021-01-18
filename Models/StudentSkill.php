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

    public function addStudentSkill($id)
    {
        $sqlQuery = "SELECT skill, level FROM student_skill WHERE user_id = :userID";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":userID", $id, PDO::PARAM_INT);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch())
        {
            $dataSet[] = new StudentSkillData($row);
        }
        return $dataSet;
    }
}