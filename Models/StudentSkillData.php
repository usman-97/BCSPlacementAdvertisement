<?php

class StudentSkillData {

    protected $_user_id, $_skillID, $_skill, $_startLevel, $_endLevel;

    public function __construct($dbRow)
    {
        $this->_user_id = $dbRow['user_id'];
        $this->_skillID = $dbRow['skillID'];
        $this->_skill = $dbRow['skill'];
        $this->_startLevel = $dbRow['startLevel'];
        $this->_endLevel = $dbRow['endLevel'];
    }

    public function get()
    {
        return $this->_skillID;
    }

    public function getSkill()
    {
        return $this->_skill;
    }

    public function getStartLevel()
    {
        return $this->_startLevel;
    }

    public function getEndLevel()
    {
        return $this->_endLevel;
    }
}