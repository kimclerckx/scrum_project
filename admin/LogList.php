<?php
require_once '../Database.php';

class LogList{
    public function getAllLogs($aantLogs)
    {
        $db = new Database();
        $sql = "SELECT * FROM logs LIMIT  $aantLogs";
        $db->executeWithoutParam($sql);
        $resultSet = $db->resultset();
        $db = null;
        $logList = array();
        foreach ($resultSet as $value) {
            array_push($logList, $value);
        }
        return $logList;
    }
    
    public function getLastId(){
        
        $db= new Database();
        $sql = "SELECT  MAX(ID) FROM logs ";
        $id = $db->executeWithoutParam($sql);
        $db = null;
        return $id;
        
        
    }
    
    }