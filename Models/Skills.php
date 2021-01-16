<?php
require_once ("Database.php");


class Skills {
    protected $_dbInstance, $_dbHandle;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function listPlacementSkills()
    {
        $sqlQuery = "SELECT * ";
    }
}