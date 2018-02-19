<?php
require_once 'Database.php';

if(!isset($_SESSION)) 
{
   session_start();
}

$sessionID = session_id();
echo $sessionID;
   
$db = new Database();
$sql = "SELECT * FROM logs WHERE sessionID = :sessionID";
$db->executeWithParam($sql, array(array(':sessionID', $sessionID)));
   
if ($db->rowCount() == 0) {
    $lastnode = 1;
    $sql = "INSERT INTO logs (sessionID, lastnode) VALUES (:sessionID, :lastnode)";
    $db->executeWithParam ($sql, array(array(':sessionID', $sessionID),array(':lastnode', $lastnode)));
    $db = null;
} else {
    $id = 1;
    $sql = 'UPDATE logs SET lastnode = :id, timestampEnd = CURRENT_TIMESTAMP WHERE sessionID = :sessionID';
    $db->executeWithParam ($sql, array(array(':id', $id),array(':sessionID', $sessionID)));
    $db = null;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $db = new Database();
    $sql = 'UPDATE logs SET lastnode = :id, timestampEnd = CURRENT_TIMESTAMP WHERE sessionID = :sessionID';
    $db->executeWithParam ($sql, array(array(':id', $id),array(':sessionID', $sessionID)));
    $db = null;
}
   


?>