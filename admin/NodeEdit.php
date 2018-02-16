<?php

require_once 'NodeList.php';

//if (!isset($_SESSION['email'])) {
//    header("Location:index.php");
//}

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
$nodeList = new NodeList();
$result = false;

if (isset($_GET["action"]) && ($_GET["action"] == "replace")) {
    $edit_data = $_POST['content'];
    $result = $nodeList->upDateNode($_GET["id"], $edit_data, $button);
    
    if ($result) {
        $alertMsg = 'Node aangepast!';
    } else {
        $alertMsg = 'Er is een fout opgetreden. Probeer nog eens';
    }
    
    echo "<script>
    window.alert(". $alertMsg .");
    window.location.href='loggedIn.php';
    </script>";
}

if (isset($_POST['add'])) {
    
    $add_content = $_POST['content'];
    $parentid = $_POST['id'];
    $result = $nodeList->addNode($parentid, $add_content, $button);
    
    if ($result) {
        $alertMsg = 'Node toegevoegd!';
    } else {
        $alertMsg = 'Er is een fout opgetreden. Probeer nog eens';
    }
    
    echo "<script>
    window.alert(". $alertMsg .");
    window.location.href='loggedIn.php';
   </script>";
 
}

//Object aanmaken
$content = $nodeList->getContentByID($_GET["id"]);

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
            <?php 
                if ($_GET['action'] == 'edit') {
            ?>
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
            <?php 
                } else if ($_GET['action'] == 'add') {
            ?>  
            
            <form action="NodeEdit.php" method="post">
                <textarea name="content" id="ckeditor" placeholder="Schrijf hier de nieuwe text"> </textarea>
                <script>
                    CKEDITOR.replace( 'ckeditor' );
                </script>
                
                Knop telefoon toevoegen: <input type="checkbox" name="red">
                Knop chat toevoegen: <input type="checkbox" name="yellow">
                
                <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
                
                <input type="submit" value="Toevoegen" name="add">
            </form> 
            
            
            
            <?php 
                }
            ?>
            
            
            
            
        </div>
        <div class="col"></div>
    </div>
</div>
</body>
</html>

