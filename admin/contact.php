<?php
require_once '../Database.php';
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

class Contact {

    public function getContact() {
        $db = new Database();
        $sql = 'SELECT * FROM contact';
        $db->executeWithoutParam($sql);
        $result = $db->single();
        $db = null;
        return $result;
    }

    public function updateContact($phone, $link) {
        $db = new Database();
        $sql = 'UPDATE contact set phone = :phone, link = :link where ID = 1';
        $db->executeWithParam($sql, array(array(':phone', $phone), array(':link', $link)));
        $db = null;
    }

}

if (!isset($_SESSION['email'])) {
    header("Location:index.php");
}

$contact = new Contact();

if (isset($_POST['contactEdit'])) {
    $contact->updateContact($_POST['phone'], $_POST['link']);
    echo ("<script>
    window.alert('Wijzigingen opgeslagen');
    window.location.href='loggedIn.php';
    </script>");
}

if (isset($_POST['close'])){
    
    
  if (isset($_GET['url']) && $_GET['url'] == 'logs') {
      
      echo ("<script>
        window.location.href='logs.php';
        </script>");
  }elseif($_GET['url'] == 'loggedIn') {
      echo ("<script>
        window.location.href='loggedIn.php';
        </script>");
}
}


   echo $_GET['url'];

  
?>

<!-- Including header -->
<?php require_once ('include/header.php'); ?>
<body>
    <div class="container">
        <div class="col-4 mx-auto text-center">
            <?php
                $result = $contact->getContact();
            ?>
            <form action="contact.php" method="post">
                <div class="form-group">
                    Telefoon: <input type="tel" class="form-control" id="phoneEdit" name="phone" value="<?= $result['phone'] ?>">
                </div>
                <div class="form-group">
                    Link<input type="url" class="form-control" id="linkEdit" value="<?= $result['link'] ?>" name="link">
                </div>
                <button type="submit" class="btn btn-primary" name="contactEdit">Opslaan</button>
                <button class="btn btn-secondary" name="close">Sluiten</button>
            </form>
        </div>
    </div>
</body>
</html>
