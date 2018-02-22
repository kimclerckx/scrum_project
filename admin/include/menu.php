<?php
if(!isset($_SESSION)) {
    session_start();
}

?>



<!--  header menu-->

<div class="header text-center">
    
    <p>Welkom <?= $_SESSION['email'] ?>: je bent nu ingelogd als administrator.</p>
   
    <div><a class='btn btn-primary' href='contact.php' target='_self'>Pas contactgegevens aan </a></div>
    <div><a class='btn btn-primary' href='passwordChange.php'>Wijzig wachtwoord</a></div>
    
<!--     checking witch page we are on-->
    
    <script type="text/javascript">
        var x = location.href;

        <?php $url = "<script>document.write(x)</script>"?>   
    </script>
<!--    $url contains location of the page we are on, already tested-->
    
<!--    <?php echo $url;?>-->
    
    <?php if (strpos($url,'logs')){ ?>
    <div><a class='btn btn-primary' href='loggedIn.php'>Bewerk</a></div>
 <?php   
}else{  ?>
    <div><a class='btn btn-primary' href='logs.php'>Logs</a></div>
    <?php
}
    ?>
    
    
    <div><a class='btn btn-primary' href='logs.php'>Logs</a></div>
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
