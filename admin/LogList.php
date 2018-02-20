<?php
require_once '../Database.php';

class LogList{
    public function getAllLogs()
    {
        $db = new Database();
        $sql = "SELECT * FROM logs LIMIT 50";
        $db->executeWithoutParam($sql);
        $resultSet = $db->resultset();
        $db = null;
        $logList = array();
        foreach ($resultSet as $value) {
            array_push($logList, $value);
        }
        return $logList;
    }
    }