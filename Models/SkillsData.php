<?php

class SkillsData {

    protected $_skillID, $_skill, $_startLevel, $_endLevel;

    public function __construct($dbRow)
    {
        $this->_skillID = $dbRow['skillID'];
        $this->_skill = $dbRow['skill'];
        $this->_startLevel = $dbRow['startLevel'];
        $this->_endLevel = $dbRow['skillID'];
    }
}