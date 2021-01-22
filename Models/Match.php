<?php
require_once ("Database.php");
require_once ("MatchData.php");
require_once ("MatchExtendedData.php");
require_once ("PlacementDataSet.php");
require_once ("MessageData.php");

/**
 * Class Match
 */
class Match {

    protected $_dbInstance, $_dbHandle;

    /**
     * Match constructor.
     */
    public function __construct()
    {
        // Creates Instance of Database class
        $this->_dbInstance = Database::getInstance();
        // Establish the connection to database
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * Find students with same location and sector as target placement
     * @param $address
     * @param $sector
     * @return array|false
     */
    public function checkLocationSector($address, $sector)
    {
        // SQL query to get users from same location and sector as placement
        $sqlQuery = "SELECT userID FROM users, student WHERE user_type = 'Student' AND postal_address LIKE CONCAT('%', :address, '%') AND users.userID = student.user_id AND sector = :sector";
        $statement = $this->_dbHandle->prepare($sqlQuery); // Prepare PDO statement
        // Assign values to parameters in SQL query
        $statement->bindParam(":address", $address, PDO::PARAM_STR);
        $statement->bindParam(":sector", $sector, PDO::PARAM_STR);
        $statement->execute(); // Execute PDO statement

        $students = []; // list of student with same location and sector as placement
        // If some students are found
        if ($statement->rowCount() > 0)
        {
            // Then fetch records from database
            while ($row = $statement->fetch())
            {
                $students[] = $row['userID'];
            }
            return $students;
        }
        else
        {
            return false;
        }
    }

    /**
     * Find students with same skills and skill level as required
     * skills for placement
     * @param $student
     * @param $placement
     * @return array|false
     */
    public function checkStudentSkills($student, $placement)
    {
        // SQL query to find student skills which match placement
        $sqlQuery = "SELECT skill FROM student_skill, skills, placement_skills WHERE user_id = :student 
                                                            AND student_skill.skill_id = skills.skillID 
                                                            AND skills.skillID = placement_skills.skill_id 
                                                            AND placement_id = :placement 
                                                            AND student_skill.level >= placement_skills.level";
        $statement = $this->_dbHandle->prepare($sqlQuery); // Prepare PDO statement
        // Assign values to parameters in SQL query
        $statement->bindParam(":student",$student, PDO::PARAM_INT);
        $statement->bindParam(":placement",$placement, PDO::PARAM_INT);
        $statement->execute(); // Execute PDO statement

        // List where student matched skills will be stored
        $student = [];
        // If student skill match
        if ($statement->rowCount() > 0)
        {
            while ($row = $statement->fetch())
            {
                $student[] = $row['skill'];
            }
            return $student;
        }
        else
        {
            return false;
        }
    }

    /**
     * Get All required skills from target placement
     * @param $placement
     * @return array|false
     */
    public function getAllPlacementSkills($placement)
    {
        // SQL query to get all skills for target placement
        $sqlQuery = "SELECT skill FROM placement_skills, skills WHERE placement_id = :placement AND placement_skills.skill_id = skills.skillID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // Prepare PDO statement
        $statement->bindParam(":placement", $placement, PDO::PARAM_INT); // Assign values to parameter in SQL query
        $statement->execute(); // Execute PDO statement

        // List where all skills will be stored
        $placementSkills = [];
        if ($statement->rowCount() > 0)
        {
            while ($row = $statement->fetch())
            {
                $placementSkills[] = $row['skill'];
            }
            return $placementSkills;
        }
        else
        {
            return false;
        }
    }

    public function showCandidates($user)
    {
        $sqlQuery = "SELECT user_id, skill, level FROM student_skill, skills WHERE user_id = :user AND student_skill.skill_id = skills.skillID ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":user", $user, PDO::PARAM_INT);
        $statement->execute();

        $finalMatches = [];
        // var_dump($statement->fetch());
        if ($statement->rowCount() > 0)
        {
            while ($row = $statement->fetch())
            {
                $finalMatches[] = new MatchData($row);

            }
            return $finalMatches;
        }
        else
        {
            return false;
        }
    }

    public function countMatchID()
    {
        $sqlQuery = "SELECT COUNT(matchID) FROM matches";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function addMatch($student, $placement)
    {
        $newKey = $this->countMatchID() + 1;

        $sqlQuery = "INSERT INTO matches VALUES (:id, :student, :placement)";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $newKey, PDO::PARAM_INT);
        $statement->bindParam(":student", $student, PDO::PARAM_INT);
        $statement->bindParam(":placement", $placement, PDO::PARAM_INT);
        $statement->execute();
    }

    public function checkMatch($id, $placement)
    {
        $sqlQuery = "SELECT * FROM matches WHERE user_id = :id AND placement_id = :placement";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->bindParam(":placement", $placement, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function getAllMatches($employer)
    {
        $placement = new PlacementDataSet();
        $employerID = $placement->findEmployerID($employer);
        // var_dump($employerID);

        $sqlQuery = "SELECT userID, full_name, email, postal_address, phone_number, placementID, title FROM users, placement, matches WHERE users.userID = matches.user_id AND matches.placement_id = placement.placementID AND employer_id = :id";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $employerID, PDO::PARAM_INT);
        $statement->execute();

        $dataSet = [];
        if ($statement->rowCount() > 0)
        {
            while ($row = $statement->fetch())
            {
                $dataSet[] = new MatchExtendedData($row);
            }
            return $dataSet;
        }
        else
        {
            return false;
        }
    }

    public function getMatchFile($id)
    {
        $sqlQuery = "SELECT cv FROM student WHERE user_id = :id";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $file = $statement->fetchColumn();
        // var_dump($file);
        if ($file != null)
        {
            return $file;
        }
        else
        {
            return false;
        }
    }

    public function countMessageID()
    {
        $sqlQuery = "SELECT COUNT(messageID) FROM messages";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function findFullName($id)
    {
        $sqlQuery = "SELECT full_name FROM users WHERE userID = :id";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchColumn();
    }

    public function sendMessage($id, $placement)
    {
        $newKey = $this->countMessageID() + 1;
        $date = date("Y-m-d");
        $incrementDate = strtotime("+3 day", strtotime($date));
        $expiryDate = date("Y-m-d", $incrementDate);
        // var_dump($expiryDate);
        $name = $this->findFullName($id);
        $message = "Hello $name, Your CV is being reviewed for $placement";

        $sqlQuery = "INSERT INTO messages VALUES (:id, :user_id, :message, :expiry)";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $newKey, PDO::PARAM_INT);
        $statement->bindParam(":user_id", $id, PDO::PARAM_INT);
        $statement->bindParam(":message", $message, PDO::PARAM_STR);
        $statement->bindParam(":expiry", $expiryDate, PDO::PARAM_STR);

        $statement->execute();
    }

    /*public function checkInbox()
    {
        $sqlQuery = "SELECT COUNT(messageID) FROM messages";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        return $statement->fetchColumn();
    }*/

    public function getMessages($id)
    {
        $sqlQuery = "SELECT * FROM messages WHERE user_id = :id";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $dataSet = [];
        if ($statement->rowCount() > 0)
        {
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

    public function deleteMessage($id)
    {
        $sqlQuery = "DELETE FROM messages WHERE messageID = :id";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }
}