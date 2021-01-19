<?php

class StudentSkillData {

    protected $_skillID, $_skill, $_level;

    public function __construct($dbRow)
    {
        $this->_skillID = $dbRow['skillID'];
        $this->_skill = $dbRow['skill'];
        $this->_level = $dbRow['level'];
    }

    public function getUserID()
    {
        return $this->_user_id;
    }

    public function getSkillID()
    {
        return $this->_skillID;
    }

    public function getSkill()
    {
        return $this->_skill;
    }

    public function getLevel()
    {
        return $this->_level;
    }
}