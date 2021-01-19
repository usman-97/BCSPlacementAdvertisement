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
        // SQL query to insert student skills
        $sqlQuery = "INSERT INTO student_skill VALUES (:userID, :skill_id, :skillLevel)";
        $statement = $this->_dbHandle->prepare($sqlQuery); // Prepare PDO statement

        // Assign values to SQL query parameters
        $statement->bindParam(":userID", $id, PDO::PARAM_INT);
        $statement->bindParam(":skill_id", $skill, PDO::PARAM_INT);
        $statement->bindParam(":skillLevel", $level, PDO::PARAM_INT);
        $statement->execute();

        /*$dataSet = [];
        while ($row = $statement->fetch())
        {
            $dataSet[] = new StudentSkillData($row);
        }
        return $dataSet;*/
    }

    /**
     * @param $user
     * @param $skill
     * @return bool
     */
    public function checkSkill($user, $skill)
    {
        $sqlQuery = "SELECT skill_id FROM student_skill WHERE user_id = :userID AND skill_id = :id";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":userID", $user, PDO::PARAM_INT);
        $statement->bindParam(":id", $skill, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function showStudentSkills($user)
    {
        $sqlQuery = "SELECT skillID, skill, level FROM student_skill, skills WHERE user_id = :id AND student_skill.skill_id = skills.skillID";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $user, PDO::PARAM_INT);
        $statement->execute();

        $dataSet = [];
        if ($statement->rowCount() > 0) {
            while ($row = $statement->fetch()) {
                $dataSet[] = new StudentSkillData($row);
            }
            return $dataSet;
        }
        else
        {
            return false;
        }
    }
}