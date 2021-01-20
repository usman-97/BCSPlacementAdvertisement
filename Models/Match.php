<?php

/**
 * Class Match
 */
class Match {

    /**
     * Match constructor.
     */
    public function __construct()
    {

    }

    public function checkLocationSector($address, $sector)
    {
        $sqlQuery = "SELECT userID FROM users, student WHERE user_type = 'Student' AND postal_address = :address AND users.userID = student.user_id AND sector = :studentSector";
    }
}