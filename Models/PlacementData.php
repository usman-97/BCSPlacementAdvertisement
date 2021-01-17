<?php

class PlacementData {

    protected $_placement_id, $_description, $_benefits, $_salary, $_salarlyPaid, $_startDate, $_endDate;

    public function __construct($dbRow)
    {
        $this->_placement_id = $dbRow['placement_id'];
        $this->_description = $dbRow['description'];
        $this->_benefits = $dbRow['benefits'];
        $this->_salary = $dbRow['salary'];
        $this->_salarlyPaid = $dbRow['salaryPaid'];
        $this->_startDate = $dbRow['start_date'];
        $this->_endDate = $dbRow['end_date'];
    }

    /**
     *
     */
    public function getPlacementID()
    {
        return $this->_placement_id;
    }

    /**
     *
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     *
     */
    public function getBenefits()
    {
        return $this->_benefits;
    }

    /**
     *
     */
    public function getSalary()
    {
        return $this->_salary;
    }

    /**
     *
     */
    public function getSalaryPaid()
    {
        return $this->_salarlyPaid;
    }

    /**
     *
     */
    public function getStartDate()
    {
        return $this->_startDate;
    }

    /**
     *
     */
    public function getEndDate()
    {
        return $this->_endDate;
    }
}