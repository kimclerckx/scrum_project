<?php

require_once 'NodeList.php';

/* Controleren welke button(s) er moeten toegevoegd worden. (checkboxes) */
$button= 0;
if(isset($_POST['red']) && isset($_POST['yellow'])){
    
    $button = 3;
    
}elseif(isset($_POST['red']) && !isset($_POST['yellow'])){
    
    $button = 1;
}elseif(!isset($_POST['red']) && isset($_POST['yellow'])){
    
    $button = 2;
}

/* Nodes updaten */
$edit = new NodeList();
$updated = false;
if (isset($_GET["action"]) && ($_GET["action"] == "replace")) {
    $edit_data = $_POST['content'];
    $edit->upDateNode($_GET["id"], $edit_data, $button);
    $updated = true;
  
    header ("location:loggedIn.php");
}

//Object aanmaken
$content = $edit->getContentByID($_GET["id"]);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Admin Login</title>
    <script src="../ckeditor/ckeditor.js"></script>

</head>
<body>
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col"></div>
        <div class="col-10 text-center">
            
            <form action="NodeEdit.php?action=replace&id=<?= $_GET["id"]?>" method="post">
                <textarea name="content" id="ckeditor">
                  <?php print $content['content'];?>  
                </textarea>
                <script>
                    CKEDITOR.replace( 'ckeditor' );
                </script>
                Knop telefoon toevoegen: <input type="checkbox" name="red"    
                    <?php
                        $bt = $content['button'];
                        if ($bt == 1 || $bt == 3){
                            print ("checked");
                        }
                    ?>>
                    Knop chat toevoegen: <input type="checkbox" name="yellow" 
                    <?php
                        if ($bt == 2 || $bt == 3){
                            print ("checked");
                        }
                    ?>>
                <input type="submit" value="Opslaan">
            </form>
            
        </div>
        <div class="col"></div>
    </div>
</div>
</body>
</html>

