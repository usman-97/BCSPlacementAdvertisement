<?php

class PlacementData {

    protected $_placement_id, $_description, $_benefits, $_salary, $_salarlyPaid, $_startDate, $_endDate;

    public function __construct($dbRow)
    {
        $this->_placement_id = $dbRow['placement_id'];
        $this->_description = $dbRow['description'];
        $this->_benefits = $dbRow['benefits'];
        $this->_salary = $dbRow['salary'];
        $this->_placement_id = $dbRow['placement_id'];
        $this->_placement_id = $dbRow['placement_id'];
    }
}