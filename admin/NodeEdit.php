<?php

require_once 'NodeList.php';
if(!isset($_SESSION)) { 
    session_start(); 
} 

if (!isset($_SESSION['email'])) {
    header("Location:index.php");
}

if (isset($_SESSION['message'])) {
     echo "<script>
        window.alert('Inhoud mag niet leeg zijn');
        </script>";
    unset($_SESSION['message']);
}


/* Controleren welke button(s) er moeten toegevoegd worden. (checkboxes) */
$button= 0;

if(isset($_POST['red']) && isset($_POST['yellow'])){
    $button = 3;
} elseif(isset($_POST['red']) && !isset($_POST['yellow'])){
    $button = 1;
} elseif(!isset($_POST['red']) && isset($_POST['yellow'])) {
    $button = 2;
}



/******** check if textarea isn't empty **********/
$errors = [];
$nodeList = new NodeList();

if(isset($_POST['add'])){
    
    if (empty($_POST['content'])) {
        $errors[] = "Vul het veld in!";
    }    // Add node

    if (count($errors) == 0) {
        $add_content = $_POST['content'];
        $parentid = $_POST['id'];
        $nodeList->addNode($parentid, $add_content, $button);
        echo "<script>
        window.alert('Opgeslagen');
        window.location.href='loggedIn.php';
        </script>";

    } else {
        $_SESSION['message'] = 'Inhoud mag niet leeg zijn';
        header ('Location: NodeEdit.php?action=add&id=' . $_POST['id'] . '');
    }
}

// Update node
if (isset($_GET["action"]) && ($_GET["action"] == "replace")) {
    $edit_data = $_POST['content'];
    $result = $nodeList->upDateNode($_GET["id"], $edit_data, $button);
    echo "<script>
    window.alert('Aangepast');
    window.location.href='loggedIn.php';
   </script>";
}


//Object aanmaken
 $content = $nodeList->getContentByID($_GET["id"]);

?>

<!-- Including header -->
<?php require_once ('include/header.php'); ?>
<body>
<div class="container">
    <div class="row">
        <div class="mx-auto col-10 text-center">
            <?php 
                if ($_GET['action'] == 'edit') {
            ?>
            <form action="NodeEdit.php?action=replace&id=<?= $_GET["id"] ?>" method="post">
                <textarea name="content" id="ckeditor">
                    <?php print $content['content']; ?>  
                </textarea>

                Knop telefoon toevoegen: <input type="checkbox" name="red"    
                <?php
                    $bt = $content['button'];
                    if ($bt == 1 || $bt == 3) {
                        print ("checked");
                    }
                    ?>>
                    Knop chat toevoegen: <input type="checkbox" name="yellow" 
                    <?php
                    if ($bt == 2 || $bt == 3) {
                        print ("checked");
                    }
                    ?>>
                    <div class="btn-set"><input class="btn btn-primary" type="submit" value="Opslaan">
                        <a class="btn btn-primary" href="loggedIn.php">Annuleer</a></div>
                    
            </form>
         

            <?php 
                } else if ($_GET['action'] == 'add') {
            ?>  
            
            <form action="NodeEdit.php" method="post">
                <textarea name="content" id="ckeditor" placeholder="Schrijf hier de nieuwe text"> </textarea>
                
                Knop telefoon toevoegen: <input type="checkbox" name="red">
                Knop chat toevoegen:<input type="checkbox" name="yellow">
                
                <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
                
                <input class="btn btn-primary" type="submit" value="Toevoegen" name="add">
                <a class="btn btn-primary" href="loggedIn.php"> Cancel </a>
                <p><?php echo implode("<br><br>", $errors);?></p>
            </form> 
            
            <?php 
                }
            ?>   
        </div>
    </div>
</div>

<!-- Including all the scripts -->
<?php require_once('include/scripts_footer.php') ?>
<script src="../ckeditor/ckeditor.js"></script>
<script> CKEDITOR.replace( 'ckeditor' ); </script>

</body>
</html>

