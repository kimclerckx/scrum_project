<?php
    //connection to database
    require_once 'Database.php';
    $db = new Database();
    //Select all the nodes with parentID 1 except the first dummy
    $sql = "SELECT * FROM nodes WHERE parentID = 1 AND ID != 1";
    //see custom database file
    $db->executeWithoutParam($sql);
    //Fetch all the data
    $resultSet = $db->resultset();
    $db = null;
?>
<!DOCTYPE html>
<!--
index.php
-->
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favico.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/favico.png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <title>De wegwijzer | oever</title>
</head>
<body>
<header>
    <div class="top">
        <div class="wrapper">
            <div class="top-container">
                <div class="logo"><img src="images/logo-oeverdef.png"></div>
                <div class="site-name"> De oever</div>
            </div>
        </div>
    </div>

</header>

<div class="wrapper">
    <h1>De wegwijzer</h1>
    <div class="node-container">
        <?php
        //Loop through $resultset and create html for each node with content
        foreach ($resultSet as $value) {
        echo '<div class="node1 item"><a href="#">';
        echo $value['content'];
        echo '</a></div>';
        } ?>
    </div>
</div>
</body>
</html>
