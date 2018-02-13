<?php

require_once 'Database.php';

function getContentNodes ()  {
    $id = $_GET['id'];

    $db = new Database();

    $sql = "SELECT * FROM nodes WHERE parentID = :id";
    $db->executeWithParam($sql, array(array(':id', $id)));
    $resultSet = $db->resultset();
    $db = null;

    //we receive een array from database, end make JSON array to send it to AJAX
    $nodes = json_encode($resultSet);
    
    return $nodes;
}

$data = getContentNodes();
echo $data;

// Bjorn says that we need it, i do not know why
flush();


