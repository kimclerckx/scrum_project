<?php

    if(!isset($_SESSION)) {
        session_start();
    }

?>

<!-- Header menu -->

<div class="header text-center">
    
    <p>Welkom <span><?= $_SESSION['email'] ?></span>: je bent nu ingelogd als administrator.</p>
   
    <div><a class='btn btn-primary' href='contact.php'>Pas contactgegevens aan </a></div>
    <div><a class='btn btn-primary' href='passwordChange.php'>Wijzig wachtwoord</a></div>
    
   <?php 
        if (strpos($_SERVER['REQUEST_URI'],'logs') > 1) { 
            echo ("<div><a class='btn btn-primary' href='loggedIn.php'>Bewerk</a></div>");            
        } else { 
            echo ("<div><a class='btn btn-primary' href='logs.php'>Logs</a></div>");
        }
    ?>
    
    <div><a class='btn btn-primary' href='logout.php'>Logout</a></div>
    <div>
    <form class="form-horizontal" action="exportToCSV.php" method="post" name="upload_excel"
          enctype="multipart/form-data">
        <div class="form-group">
                <input type="submit" name="Export" class="btn btn-success" value="Exporteer naar Excel"/>
        </div>
    </form>
    
</div>
</div>
