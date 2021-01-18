<?php
require_once ("Database.php");
require_once ("PlacementData.php");

/**
 * Class PlacementDataSet
 */
class PlacementDataSet {
    protected $_dbInstance, $_dbHandle, $_placement_id;

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
        $sqlQuery = "SELECT * FROM placement ORDER BY end_date DESC";
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

    /**
     * @param $title
     * @param $description
     * @param $benefits
     * @param $salary
     * @param $salaryPaid
     * @param $start_date
     * @param $end_date
     */
    public function createPlacement($title, $description, $benefits, $salary, $salaryPaid, $start_date, $end_date)
    {
        // SQL query counts placement rows
        $countQuery = "SELECT COUNT(placementID) FROM placement";
        // Prepare PDO statement
        $countStatement = $this->_dbHandle->prepare($countQuery);
        $countStatement->execute();

        $newKey = $countStatement->fetchColumn() + 1;
        $this->_placement_id = $newKey;

        $sqlQuery = "INSERT INTO placement VALUES (:id, :title, :description, :benefits, :salary, :salaryPaid, :start_date, :end_date)";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $newKey, PDO::PARAM_INT);
        $statement->bindParam(":title", $title, PDO::PARAM_STR);
        $statement->bindParam(":description", $description, PDO::PARAM_STR);
        $statement->bindParam(":benefits", $benefits, PDO::PARAM_STR);
        $statement->bindParam(":salary", $salary, PDO::PARAM_INT);
        $statement->bindParam(":salaryPaid", $salaryPaid, PDO::PARAM_STR);
        $statement->bindParam(":start_date", $start_date, PDO::PARAM_STR);
        $statement->bindParam(":end_date", $end_date, PDO::PARAM_STR);

        $statement->execute();
    }

    public function getPlacementID()
    {
        return $this->_placement_id;
    }
}