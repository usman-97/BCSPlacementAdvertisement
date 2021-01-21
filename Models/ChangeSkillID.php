<?php

require_once ("Database.php");

class ChangeSkillID {
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function changeID($newID, $id)
    {
        $sqlQuery = "UPDATE skills SET skillID = :newId WHERE skillID = :id";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":newId", $newID, PDO::PARAM_INT);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }
}