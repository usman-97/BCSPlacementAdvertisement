<?php

class MatchExtendedData {

    protected $_userID, $_fullName, $_email, $_address, $_phone_number, $_placementID, $_title;

    public function __construct($dbRow)
    {
        $this->_userID = $dbRow['userID'];
        $this->_fullName = $dbRow['full_name'];
        $this->_email = $dbRow['email'];
        $this->_address = $dbRow['postal_address'];
        $this->_phone_number = $dbRow['phone_number'];
        $this->_placementID = $dbRow['placementID'];
        $this->_title = $dbRow['title'];
    }

    public function getUserID()
    {
        return $this->_userID;
    }

    public function getFullName()
    {
        return $this->_fullName;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function getAddress()
    {
        return $this->_address;
    }

    public function getPhoneNumber()
    {
        return $this->_phone_number;
    }

    public function getPlacementID()
    {
        return $this->_placementID;
    }

    public function getTitle()
    {
        return $this->_title;
    }
}