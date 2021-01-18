<?php
require_once ("Database.php");
require_once ("SkillsData.php");

/**
 * Class Skills
 */
class Skills {
    protected $_dbInstance, $_dbHandle;

    /**
     * Skills constructor.
     */
    public function __construct()
    {
        // Create Instance of Database
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * Lists all placements and their details
     * @return array
     */
    public function listPlacementSkills()
    {
        // SQL query to get all skills and their details
        $sqlQuery = "SELECT * FROM skills ORDER BY skill";
        // Prepare PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        // Execute PDO statement
        $statement->execute();

        // Array list where are skills and their details will be stored
        $dataSet = [];
        while ($row = $statement->fetch())
        {
            $dataSet[] = new SkillsData($row);
        }

        return $dataSet;
    }

    /**
     * Add skills to placement
     */
    public function addSkill($skillID, $placementID)
    {
        $sqlQuery = 'INSERT INTO placement_skills VALUES ()';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->
        $statement->execute();
    }
}