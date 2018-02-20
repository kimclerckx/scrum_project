<?php
require_once 'LogList.php';
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
if(!isset($_GET['page']))
{
    $_GET['page'] = 1;
}

if (isset($_POST['aantLogs'])) {
    $_SESSION['aantLogs'] = $_POST['aantLogs'];
} else {
    $_SESSION['aantLogs'] = 25;
}
$aantLogs = $_SESSION['aantLogs'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logs</title>
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
<!--Check if user is logged in-->
<?php
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
} else { ?>
    <div class="header">
        <p>Welkom <?= $_SESSION['email']?> : je bent nu ingelogd als administrator.</p>
        <a class='btn btn-primary' href='logout.php'>Logout</a>
    </div>
<?php } ?>
<!--Show log records-->
   <div>
        <form action="logs.php" method="post">
         <select name="aantLogs" id="aantLogs">
         <option value="25"<?php echo (isset($_POST['aantLogs']) && $_POST['aantLogs'] == '25')?'selected="selected"':''; ?> >25</option>
             <option value="50"<?php echo (isset($_POST['aantLogs']) && $_POST['aantLogs'] == '50')?'selected="selected"':''; ?> >50</option>
             <option value="75"<?php echo (isset($_POST['aantLogs']) && $_POST['aantLogs'] == '75')?'selected="selected"':''; ?> >75</option>
             <option value="100"<?php echo (isset($_POST['aantLogs']) && $_POST['aantLogs'] == '100')?'selected="selected"':''; ?> >100</option>
         </select>
        <input type="submit">
        </form>
    </div>
   
    <?php
        $ll = new LogList();
        $logCount = $ll->getLogCount();

    echo $logCount;
    $aantPages = ceil($logCount/$aantLogs);
    $list = $ll->getLogs($aantLogs, $_GET['page']);

    echo '<br>' . $aantPages;
    
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

           <?php
           for ($i=1;$i <= $aantPages;$i++) {
               echo "<a href='logs.php?page=" . $i . "'>". ($aantLogs*($i-1)). '-' . ($aantLogs*$i) ."</a>";
           }
           ?>


        </div>  
</body>
</html>
