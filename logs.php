<?php
require_once 'Database.php';

// if it's new user - start session
if(!isset($_SESSION)) 
{
   session_start();
}

// Take the session id of user
$sessionID = session_id();

// Check if session id is already in database
$db = new Database();
$sql = "SELECT * FROM logs WHERE sessionID = :sessionID";
$db->executeWithParam($sql, array(array(':sessionID', $sessionID)));

// if it's new session id - add new row in DB
if ($db->rowCount() == 0) {
    $lastnode = 1;
    $sql = "INSERT INTO logs (sessionID, lastnode) VALUES (:sessionID, :lastnode)";
    $db->executeWithParam ($sql, array(array(':sessionID', $sessionID),array(':lastnode', $lastnode)));
    $db = null;
} else { // update the current session id and set lastnode = 1 (if page is refreshed)
    $id = 1;
    $sql = 'UPDATE logs SET lastnode = :id, timestampEnd = CURRENT_TIMESTAMP WHERE sessionID = :sessionID';
    $db->executeWithParam ($sql, array(array(':id', $id),array(':sessionID', $sessionID)));
    $db = null;
}

// With AJAX we are giving id of last node, so then we can update our logs
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $db = new Database();
    $sql = 'UPDATE logs SET lastnode = :id, timestampEnd = CURRENT_TIMESTAMP WHERE sessionID = :sessionID';
    $db->executeWithParam ($sql, array(array(':id', $id),array(':sessionID', $sessionID)));
    $db = null;
}
?>