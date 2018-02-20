<?php
require_once 'LogList.php';
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
} else {
    echo '<div class="header">';
        echo "<p>Welkom {$_SESSION['email']} : je bent nu ingelogd als administrator.</p>";
        echo "<a class='btn btn-primary' href='logout.php'>Logout</a>";
    echo '</div>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logs</title>
    <link rel="stylesheet" href="css/admin-style.css">
</head>

<body>
   <div>
        <form action="logs.php" method="post">

         <select name="aantLogs" id="aantLogs">
         <option value="20" default>25</option>
         <option value="50">50</option>
         <option value="100">100</option>
         <option value="150">150</option>
        
         </select>
        <input type="submit">
        </form>
    </div>
   
    
    
    

    <?php
        $aantLogs = $_POST['aantLogs'];
        $ll = new LogList();
        $list = $ll->getAllLogs($aantLogs);
        $db = new Database();
        $lastId = $db->lastInsertId();
    
    echo $lastId;
    
    ?>
       <div class="wrapperLogs">
        
           
            <span class="box">#</span>
            <span class="box">Start</span>
            <span class="box">Einde</span>
            <span class="box">Totale tijd</span>
            <span class="box">Laatste element</span>       
        
    
    <?php foreach($list as $log){ 
    
        $datetime1 = new DateTime($log['timestampStart']);
        $datetime2 = new DateTime($log['timestampEnd']);
        $duurtijd = $datetime2->diff($datetime1);

    ?>
       
            <span class="box"><?php print $log['ID'];?></span>
            <span class="box"><?php print $log['timestampStart'];?></span>
            <span class="box"><?php print $log['timestampEnd'];?></span>
            <span class="box"><?php print $duurtijd->format('%h uur %i minuten %s seconden');?></span>
            <span class="box"><?php print $log['lastnode'];?></span>
        
        

    <?php  
        } 
    ?>
        </div>  
</body>
</html>
