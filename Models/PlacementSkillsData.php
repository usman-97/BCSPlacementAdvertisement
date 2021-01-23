<?php

/**
 * Class PlacementSkillsData
 */
class PlacementSkillsData{
    protected $_skillID, $_skill, $_level;

    /**
     * PlacementSkillsData constructor.
     * @param $dbRow
     */
    public function __construct($dbRow)
    {
        $this->_skillID = $dbRow['skillID'];
        $this->_skill = $dbRow['skill'];
        $this->_level = $dbRow['level'];
    }

    /**
     * @return mixed
     */
    public function getSkillID()
    {
        return $this->_skillID;
    }

    /**
     * @return mixed
     */
    public function getSkill()
    {
        return $this->_skill;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->_level;
    }
}
