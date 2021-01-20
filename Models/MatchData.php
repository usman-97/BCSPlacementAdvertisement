<?php

class MatchData {

    protected $_user_id, $_skill, $_level;

    public function __construct($dbRow)
    {
        $this->_user_id = $dbRow['user_id'];
        $this->_skill = $dbRow['skill'];
        $this->_level = $dbRow['level'];
    }

    public function getUserID()
    {
        return $this->_user_id;
    }

    public function getSkill()
    {
        return $this->_skill;
    }

    public function getSkillLevel()
    {
        return $this->_level;
    }
}