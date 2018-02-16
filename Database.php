<?php

class Database
{
    private $host = "172.30.24.7:3306";
    private $user = "fontonova";
    private $pass = "GumHM4Q4-pYgzWdYA";
    private $dbname = "fontonova";
<<<<<<< HEAD
=======
   
>>>>>>> 8c5748ab5e74c6acc34b6494690dd824eab3bb5d

    private $dbh;
    private $error;
    private $stmt;

    public function __construct()
    {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );
        // Create a new PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } // Catch any errors
        catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function prepare($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    // bind with parameters
    //$array is array of arrays with parameters : see instructions below
    public function bind($array)
    {
        foreach ($array as $row) {
            if (!isset($row[2])) {
                switch (true) {
                    case is_int($row[1]):
                        $row[2] = PDO::PARAM_INT;
                        break;
                    case is_bool($row[1]):
                        $row[2] = PDO::PARAM_BOOL;
                        break;
                    case is_null($row[1]):
                        $row[2] = PDO::PARAM_NULL;
                        break;
                    default:
                        $row[2] = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($row[0], $row[1], $row[2]);
        }
    }

    //executeWithParam does prepare, bind and execute
    //$sql is just the normal sql with parameters
    //$arr is array of arrays
    //INSTRUCTION
    /*  $sql = 'INSERT INTO users (username, email, password)
        VALUES (:username, :email, :password)';

        $db->executeWithParam ($sql, array(array(':title', $title), array(':body', $body), array(':author', $author)));
   */
    public function executeWithParam($sql, $arr)
    {
        $this->prepare($sql);
        $this->bind($arr);
        $result = $this->execute();
        return $result;
    }

    //executeWithoutParam does prepare and execute
    //$sql is normal sql without parameters
    public function executeWithoutParam($sql)
    {
        $this->prepare($sql);
        $this->execute();
    }

    public function resultset()
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single()
    {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }
}