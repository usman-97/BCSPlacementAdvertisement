<?php

class UserData {
    protected $_email, $_phone_number, $_address;

    public function __construct($dbRow)
    {
        /*$this->_email = $dbRow['email'];
        $this->_phone_number = $dbRow['phone_number'];
        $this->_address = $dbRow['postal_address'];*/
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function getPhoneNumber()
    {
        return $this->_phone_number;
    }

    public function getAddress()
    {
        return $this->_address;
    }
}
