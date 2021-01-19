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
     * @param $start
     * @param $limit
     * @return array
     */
    public function getAllPlacements($start, $limit)
    {
        // SQL query to fetch all placement data
        $sqlQuery = "SELECT * FROM placement ORDER BY end_date DESC LIMIT :startPage, :nextPage";
        // Prepare PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":startPage", $start, PDO::PARAM_INT);
        $statement->bindParam(":nextPage", $limit, PDO::PARAM_INT);
        // Execute the PDO statement
        $statement->execute();

        // All placement data will be stored in this list
        $dataSet = [];
        // Get all data and insert it in dataSet list
        while ($row = $statement->fetch())
        {
            $dataSet[] = new PlacementData($row);
        }
        // var_dump($start, $limit);
        return $dataSet;
    }

    /**
     * @param $company
     * @param $sector
     * @param $title
     * @param $description
     * @param $benefits
     * @param $location
     * @param $salary
     * @param $salaryPaid
     * @param $start_date
     * @param $end_date
     */
    public function createPlacement($company, $sector, $title, $description, $benefits, $location, $salary, $salaryPaid, $start_date, $end_date)
    {
        // SQL query counts placement rows
        $countQuery = "SELECT COUNT(placementID) FROM placement";
        // Prepare PDO statement
        $countStatement = $this->_dbHandle->prepare($countQuery);
        $countStatement->execute();

        $newKey = $countStatement->fetchColumn() + 1;
        $this->_placement_id = $newKey;

        $sqlQuery = "INSERT INTO placement VALUES (:id, :company, :sector, :title, :description, :benefits, :location, :salary, :salaryPaid, :start_date, :end_date)";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $newKey, PDO::PARAM_INT);
        $statement->bindParam(":company", $company, PDO::PARAM_STR);
        $statement->bindParam(":sector", $sector, PDO::PARAM_STR);
        $statement->bindParam(":title", $title, PDO::PARAM_STR);
        $statement->bindParam(":description", $description, PDO::PARAM_STR);
        $statement->bindParam(":benefits", $benefits, PDO::PARAM_STR);
        $statement->bindParam(":location", $location, PDO::PARAM_STR);
        $statement->bindParam(":salary", $salary, PDO::PARAM_INT);
        $statement->bindParam(":salaryPaid", $salaryPaid, PDO::PARAM_STR);
        $statement->bindParam(":start_date", $start_date, PDO::PARAM_STR);
        $statement->bindParam(":end_date", $end_date, PDO::PARAM_STR);

        $statement->execute();
        var_dump($statement->execute());
    }

    public function getPlacementID()
    {
        return $this->_placement_id;
    }

    public function countPlacementID()
    {
        // SQL query counts placement rows
        $countQuery = "SELECT COUNT(placementID) FROM placement";
        // Prepare PDO statement
        $countStatement = $this->_dbHandle->prepare($countQuery);
        $countStatement->execute();

        return $countStatement->fetchColumn();
    }
}