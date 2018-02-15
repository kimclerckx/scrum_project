<?php
//Connect to MySQL database using PDO.
session_start();
require_once '../Database.php';
$db = new Database();

//The user's id, which should be present in the GET variable "uid"
$userId = isset($_GET['uid']) ? trim($_GET['uid']) : '';
//The token for the request, which should be present in the GET variable "t"
$token = isset($_GET['t']) ? trim($_GET['t']) : '';
//The id for the request, which should be present in the GET variable "id"
$passwordRequestId = isset($_GET['id']) ? trim($_GET['id']) : '';


//Now, we need to query our password_reset_request table and
//make sure that the GET variables we received belong to
//a valid forgot password request.

$insertSql = "SELECT ID, user_ID, date_requested 
              FROM password_reset_request
              WHERE user_ID = :user_id AND token = :token AND ID = :id";

//Prepare our INSERT SQL statement.
//Execute the statement and insert the data.
//Prepare our statement.
//Execute the statement using the variables we received.
$db->executeWithParam($insertSql, array(array(':user_id', $userId), array(':token', $token), array(':id', $passwordRequestId)));

//$sql = "
//      SELECT id, user_id, date_requested
//      FROM password_reset_request
//      WHERE
//        user_id = :user_id AND
//        token = :token AND
//        id = :id
//";

//Prepare our statement.
//Execute the statement using the variables we received.

//Fetch our result as an associative array.
$requestInfo = $db->single();

//If $requestInfo is empty, it means that this
//is not a valid forgot password request. i.e. Somebody could be
//changing GET values and trying to hack our
//forgot password system.
if(empty($requestInfo)){
    echo 'Invalid request!';
    exit;
}

//The request is valid, so give them a session variable
//that gives them access to the reset password form.
$_SESSION['user_id_reset_pass'] = $userId;

//Redirect them to your reset password form.
header('Location: passwordCreate.php');
exit;

