<?php

/**
 * Class Student
 */
class Student extends User {

    /**
     * Student constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getSector($user)
    {
        $sqlQuery = "SELECT sector FROM student WHERE user_id = :id";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $user, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchColumn();
    }

    public function addSector($user, $sector)
    {
        $sqlQuery = "UPDATE student SET sector = :selectedSector WHERE user_id = :id";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":selectedSector", $sector, PDO::PARAM_STR);
        $statement->bindParam(":id", $user, PDO::PARAM_INT);
        $statement->execute();
    }
}
