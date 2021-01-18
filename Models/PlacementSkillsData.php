<?php

/**
 * Class PlacementSkillsData
 */
class PlacementSkillsData{
    protected $_skill, $_level;

    /**
     * PlacementSkillsData constructor.
     * @param $dbRow
     */
    public function __construct($dbRow)
    {
        $this->_skill = $dbRow['skill'];
        $this->_level = $dbRow['level'];
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
