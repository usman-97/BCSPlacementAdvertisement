<?php
require_once ("Database.php");
require_once ("SkillsData.php");


class Skills {
    protected $_dbInstance, $_dbHandle;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function listPlacementSkills()
    {
        $sqlQuery = "SELECT * FROM skills";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch())
        {
            $dataSet[] = new SkillsData($row);
        }

        return $dataSet;
    }

    /**
     *
     */
    public function addSkill($skillID, $placementID)
    {
        $sqlQuery = 'INSERT INTO placement_skills VALUES ()';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->
        $statement->execute();
    }
}