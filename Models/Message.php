<?php
require_once ("Database.php");
require_once ("MessageData.php");
require_once ("Match.php");

/**
 * Class Message
 */
class Message {
    protected $_dbInstance, $_dbHandle;

    /**
     * Message constructor.
     */
    public function __construct()
    {
        // Creates Instance of Database class
        $this->_dbInstance = Database::getInstance();
        // Establish the connection to database
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * Count total records for messages table
     * @return mixed
     */
    public function countMessageID()
    {
        // SQL query to count total rows
        $sqlQuery = "SELECT COUNT(messageID) FROM messages";
        // Prepare PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();// Execute PDO statement
        return $statement->fetchColumn(); // Fetch the number of total rows
    }

    public function sendMessage($id, $message)
    {
        $newKey = $this->countMessageID() + 1;
        $date = date("Y-m-d");
        $incrementDate = strtotime("+3 day", strtotime($date));
        $expiryDate = date("Y-m-d", $incrementDate);
        // var_dump($expiryDate);

        $matchName = new Match();
        // $name = $matchName->findFullName($id);

        $sqlQuery = "INSERT INTO messages VALUES (:id, :user_id, :message, :expiry)";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $newKey, PDO::PARAM_INT);
        $statement->bindParam(":user_id", $id, PDO::PARAM_INT);
        $statement->bindParam(":message", $message, PDO::PARAM_STR);
        $statement->bindParam(":expiry", $expiryDate, PDO::PARAM_STR);

        $statement->execute();
    }

    /** Get all the messages for student user
     * @param $id
     * @return array|false
     */
    public function getMessages($id)
    {
        // SQL query to get all the messages for a user
        $sqlQuery = "SELECT * FROM messages WHERE user_id = :id";
        // Prepare PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        // Assign values to parameters in SQL query
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute(); // Execute PDO query

        // List where all messages for users will be stored
        $dataSet = [];
        // If user has any messages in their inbox
        if ($statement->rowCount() > 0)
        {
            // Get all the messages
            while ($row = $statement->fetch())
            {
                $dataSet[] = new MessageData($row);
            }
            return $dataSet;
        }
        else
        {
            return false;
        }
    }

    /**
     * Remove the message from messages table
     * @param $id
     */
    public function deleteMessage($id)
    {
        // SQL query to remove message from user inbox
        $sqlQuery = "DELETE FROM messages WHERE messageID = :id";
        // Prepare PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        // Assign value to parameter in SQL query
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute(); // Execute the PDO statement
    }
}