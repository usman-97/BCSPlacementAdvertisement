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

    public function getSector()
    {
        $sqlQuery = "SELECT sector FROM student WHERE user_id = :id";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":");
    }
}
