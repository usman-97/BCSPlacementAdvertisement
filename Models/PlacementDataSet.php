<?php
require_once ("Database.php");
require_once ("PlacementData.php");

/**
 * Class PlacementDataSet
 */
class PlacementDataSet {
    protected $_dbInstance, $_dbHandle;

    /**
     * Constructor for PlacementDataSet
     */
    public function __construct()
    {
        // Creates Instance of Database class
        $this->_dbInstance = Database::getInstance();
        // Establish the connection to database
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * Get all the placements from placement table
     */
    public function getAllPlacements()
    {
        // SQL query to fetch all placement data
        $sqlQuery = "SELECT * FROM placement";
        // Prepare PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        // Execute the PDO statement
        $statement->execute();

        // All placement data will be stored in this list
        $dataSet = [];
        // Get all data and insert it in dataSet list
        while ($row = $statement->fetch())
        {
            $dataSet[] = new PlacementData($row);
        }
        return $dataSet;
    }
}