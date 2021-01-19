<?php

class PlacementData {

    protected $_placement_id, $_company, $_sector, $_title, $_description, $_benefits, $_location,  $_salary, $_salaryPaid, $_startDate, $_endDate;

    public function __construct($dbRow)
    {
        $this->_placement_id = $dbRow['placementID'];
        $this->_company = $dbRow['company'];
        $this->_sector = $dbRow['sector'];
        $this->_title = $dbRow['title'];
        $this->_description = $dbRow['description'];
        $this->_benefits = $dbRow['benefits'];
        $this->_location = $dbRow['location'];
        $this->_salary = $dbRow['salary'];
        $this->_salaryPaid = $dbRow['salaryPaid'];
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
     * @return mixed
     */
    public function getCompany()
    {
        return $this->_company;
    }

    /**
     * @return mixed
     */
    public function getSector()
    {
        return $this->_sector;
    }

    /**
     *
     */
    public function getTitle()
    {
        return $this->_title;
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
     * @return mixed
     */
    public function getLocation()
    {
        return $this->_location;
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
        return $this->_salaryPaid;
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