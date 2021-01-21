<?php

class MessageData {
    protected $_messageID, $_user_id, $_message, $_expiry_date;

    public function __construct($dbRow)
    {
        $this->_messageID = $dbRow['messageID'];
        $this->_user_id = $dbRow['user_id'];
        $this->_message = $dbRow['message'];
        $this->_expiry_date = $dbRow['expiry_date'];
    }

    public function getMessageID()
    {
        return $this->_messageID;
    }

    public function getUserID()
    {
        return $this->_user_id;
    }

    public function getMessage()
    {
        return $this->_message;
    }

    public function getExpiryDate()
    {
        return $this->_expiry_date;
    }
}