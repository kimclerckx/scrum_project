<?php

require_once 'Database.php';
//We receive ID from ajax as parameter through get
$id = $_GET['id'];
$db = new Database();
//If we retrieve data only for divs then this ID we receive from ajax is parentID and we need to get only children with parentID = ID
//If we retrieve data for breadcrumbs, first we find the element with given ID then find the parentID of this element and find every element with the same parentID.
if ($_GET['param'] == 1) {
    $sql = "SELECT * FROM nodes WHERE parentID = :id AND ID != 1";
} else {
    $sql = "SELECT * FROM nodes WHERE ID = :id";
}

$db->executeWithParam($sql, array(array(':id', $id)));

if ($_GET['param'] == 1) {
    $resultSet = $db->resultset();
} else {
    $resultSet = $db->single();
    $id = $resultSet['parentID'];
    $sql = "SELECT * FROM nodes WHERE parentID = :id AND ID != 1";
    $db->executeWithParam($sql, array(array(':id', $id)));
    $resultSet = $db->resultset();
}

$db = null;

//we receive een array from database, end make JSON array to send it to AJAX
$nodes = json_encode($resultSet);
echo $nodes;

//Bjorn says that we need it, i do not know why
flush();


