<?php
require_once '../Database.php';

class LogList
{
    public function getLogs($aantLogs, $i)
    {
        $offset = ($i-1) * $aantLogs;
        $db = new Database();
        $sql = "SELECT * FROM logs LIMIT $aantLogs OFFSET $offset";
        $db->executeWithoutParam($sql);
        $resultSet = $db->resultset();
        $db = null;
        $logList = array();
        foreach ($resultSet as $value) {
            array_push($logList, $value);
        }
        return $logList;
    }

    public function getLogCount()
    {
        $db = new Database();
        $sql = "SELECT  COUNT(*) FROM logs ";
        $db->executeWithoutParam($sql);
        $logCount = $db->log();
        $db = null;
        return reset($logCount);
    }
}

/*$sql = "SELECT count(*) FROM `table` WHERE foo = bar";
$statement = $con->prepare($sql);
$statement->execute();
$count = $statement->fetch(PDO::FETCH_NUM); // Return array indexed by column number
return reset($count); // Resets array cursor and returns first value (the count)*/