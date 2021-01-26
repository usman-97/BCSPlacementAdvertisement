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

    /**
     * @param $id
     * @param $skill
     * @param $level
     */
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
     * @param $level
     * @return bool
     */
    public function checkSkill($user, $skill, $level)
    {
        $sqlQuery = "SELECT skill_id FROM student_skill WHERE user_id = :userID AND skill_id = :id AND level = :skillLevel";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":userID", $user, PDO::PARAM_INT);
        $statement->bindParam(":id", $skill, PDO::PARAM_INT);
        $statement->bindParam(":skillLevel", $level, PDO::PARAM_INT);
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

    /**
     * @param $user
     * @return array|false
     */
    public function showStudentSkills($user)
    {
        // SQL query to select all student skills
        $sqlQuery = "SELECT skillID, skill, level FROM student_skill, skills WHERE user_id = :id AND student_skill.skill_id = skills.skillID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // Prepare PDO statement
        $statement->bindParam(":id", $user, PDO::PARAM_INT); // Assign values to parameter in SQL query
        $statement->execute(); // Execute PDO statement

        // List to store all student skills
        $dataSet = [];
        // If student list not empty
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

    /**
     * @param $user
     * @param $skill
     */
    public function removeSkill($user, $skill)
    {
        // SQL query to remove skill from user skill inventory
        $sqlQuery = "DELETE FROM student_skill WHERE user_id = :user_id AND skill_id = :skill";
        $statement = $this->_dbHandle->prepare($sqlQuery); // Prepare PDO statement

        // Assign value to parameters in SQL query
        $statement->bindParam(":user_id", $user, PDO::PARAM_INT);
        $statement->bindParam(":skill", $skill, PDO::PARAM_INT);

        $statement->execute(); // Execute PDO statement
    }
}