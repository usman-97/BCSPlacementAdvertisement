<?php
require_once ("Database.php");
require_once ("UserData.php");

/**
 * Class User
 * This model is for user which
 * is use for user login and registration process
 */
class User {

    protected $_dbInstance, $_dbHandle, $_userID, $_email, $_password, $_userType, $_name, $_phone, $_address;

    /**
     * User Constructor
     * It creates instance of Database model
     * It establish the database connection
     *
     */
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance(); // Create Database instance
        $this->_dbHandle = $this->_dbInstance->getdbConnection(); // Establish connection to database
    }

    /**
     * Sets email field
     * @param $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * Sets password field
     * @param $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * Sets userType field
     * @param $userType
     */
    public function setUserType($userType)
    {
        $this->_userType = $userType;
    }

    /**
     * Checks if user given email is in
     * user table
     * @return bool
     */
    public function checkEmail()
    {
        // SQL query which gets user given email
        $sqlQuery = "SELECT email FROM users WHERE email = :userEmail";
        $statement = $this->_dbHandle->prepare($sqlQuery); // This prepares PDO statement
        // Assign parameter value in SQL query
        $statement->bindParam(":userEmail", $this->_email, PDO::PARAM_STR);
        $statement->execute(); // Execute PDO statement

        // If user email is found in user table
        if ($statement->rowCount() > 0)
        {
            // Then return true
            return true;
        }
        else
        {
            // otherwise return false
            return false;
        }

    }

    /**
     * Gets total number of  User IDs from users table
     * @param $id
     * @param $table
     * @return mixed
     */
    /*public function countID($id, $table)
    {
        // SQL query counts userID rows
        $countQuery = "SELECT COUNT(:id) FROM :tableName";
        // Prepare PDO statement
        $countStatement = $this->_dbHandle->prepare($countQuery);
        $countStatement->bindParam(":id", $id, PDO::PARAM_INT);
        $countStatement->bindParam(":tableName", $table, PDO::PARAM_STR);
        // Execute PDO statement
        $countStatement->execute();
        // return total number of userID records
        return $countStatement->fetchColumn();
    }*/

    /**
     * Register user as an employer or as a student
     * Inserts user information to user table
     * @param $fullName
     * @param $phoneNumber
     * @param $address
     */
    public function register($fullName, $phoneNumber, $address)
    {
        // SQL query counts userID rows
        $countQuery = "SELECT COUNT(userID) FROM users";
        // Prepare PDO statement
        $countStatement = $this->_dbHandle->prepare($countQuery);
        $countStatement->execute();

        // return total number of userID records
        $newKey = $countStatement->fetchColumn() + 1;
        $this->_userID = $newKey;

        // SQL query to insert user details
        $sqlQuery = "INSERT INTO users VALUES(:Pkey, :username, :userEmail, :pwd, :phone, :postal, :typeOfUser)";

        // Prepare PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);

        // Assign values to parameters in SQL query
        $statement->bindParam(":Pkey", $newKey, PDO::PARAM_INT);
        $statement->bindParam(":username", $fullName, PDO::PARAM_STR);
        $statement->bindParam(":userEmail", $this->_email, PDO::PARAM_STR);
        $statement->bindParam(":pwd", $password, PDO::PARAM_STR);
        $statement->bindParam(":phone", $phoneNumber, PDO::PARAM_STR);
        $statement->bindParam(":postal", $address, PDO::PARAM_STR);
        $statement->bindParam(":typeOfUser", $this->_userType, PDO::PARAM_STR);

        // Encrypt user password
        $password = password_hash($this->_password, PASSWORD_DEFAULT);

        // Execute PDO statement
        $statement->execute();
        var_dump($password);
    }

    /**
     * Insert new registered user as a student
     */
    public function addStudent()
    {
        // SQL query counts userID rows
        $countQuery = "SELECT COUNT(studentID) FROM student";
        // Prepare PDO statement
        $countStatement = $this->_dbHandle->prepare($countQuery);
        $countStatement->bindParam(":id", $id, PDO::PARAM_INT);
        $countStatement->bindParam(":tableName", $table, PDO::PARAM_STR);
        // Execute PDO statement
        $countStatement->execute();

        // New id for student table
        $newKey = $countStatement->fetchColumn() + 1;
        // SQL query to insert student and user id
        $sqlQuery = "INSERT INTO student VALUES (:id, :user_id, null)";
        // Prepare PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        // Assign values to parameters in SQL query
        $statement->bindParam(":id", $newKey, PDO::PARAM_INT);
        $statement->bindParam(":user_id", $this->_userID, PDO::PARAM_INT);
        // Execute PDO statement
        $statement->execute();
        // var_dump($this->_userID);

    }

    /**
     * Verify user email and password from users table
     */
    public function verifyUser()
    {
        // SQL query to check if user provided email match with database
        $sqlQuery = "SELECT * FROM users WHERE email = :userEmail";
        // Prepare PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        // Assign value to parameter in SQL query
        $statement->bindParam(":userEmail", $this->_email, PDO::PARAM_STR);
        // Execute PDO statement
        $statement->execute();

        // var_dump($statement->rowCount() == 1);

        // if email is found and matched in database
        if ($statement->rowCount() == 1)
        {
            $dbRow = $statement->fetch(); // Fetch records from database
            $this->_userID = $dbRow['userID']; // get userID from database
            $this->_name = $dbRow['full_name']; // get user full name from database
            $this->_userType = $dbRow['user_type']; // get type of user
            $encryptedPassword = $dbRow['password']; // get encrypted password from database
            $this->_email = $dbRow['email']; // get user email from database
            $this->_phone = $dbRow['phone_number']; // get phone number from database
            $this->_address = $dbRow['postal_address']; // get user address from database

            // if password is matched with encrypted password
            if (password_verify($this->_password, $encryptedPassword))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /*public function getUserData($id)
    {
        $sqlQuery = "SELECT full_name, phone_number, postal_address FROM users WHERE userID = :id";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch())
        {
            $dataSet[] = new UserData($row);
        }
        return $dataSet;
    }*/

    /**
     * Return user ID
     */
    public function getUserID()
    {
        return $this->_userID;
    }

    /**
     * Return full name of user
     */
    public function getFullName()
    {
        return $this->_name;
    }

    /**
     * Return type of user
     */
    public function getUserType()
    {
        return $this->_userType;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function getPhoneNumber()
    {
        return $this->_phone;
    }

    public function getAddress()
    {
        return $this->_address;
    }

}
