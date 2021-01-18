<?php
require_once ("Models/Database.php");
require_once ("Models/SkillsData.php");
require_once ("Models/PlacementData.php");

/**
 * Class PlacementSkills
 */
class PlacementSkills {
    protected $_dbInstance, $_dbHandle;

    /**
     * PlacementSkills constructor.
     */
    public function __construct()
    {
        // Creates Instance of Database class
        $this->_dbInstance = Database::getInstance();
        // Establish the connection to database
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function addPlacementSkills($placement, $skill, $level)
    {
        $sqlQuery = "INSERT INTO placement_skills VALUES (:placement, :skill, :skillLevel)";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":placement", $placement, PDO::PARAM_INT);
        $statement->bindParam(":skill", $skill, PDO::PARAM_INT);
        $statement->bindParam(":skillLevel", $level, PDO::PARAM_INT);
        $statement->execute();
    }
}