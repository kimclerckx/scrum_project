<?php
require_once '../Database.php';

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
        $sql = 'UPDATE contact set phone = :phone, link = :link where ID =1';
        $result = $db->executeWithParam($sql, array(array(':phone', $phone), array(':link', $link)));
        $db = null;
        return $result;
    }

}

$updated = FALSE;
if (isset($_GET['action']) && ($_GET['action'] == 'edit')) {
    $update = new Contact();
    $updated = $update->updateContact($_POST['phone'], $_POST['link']);
    
    if ($updated) {
        $alertMsg = 'Contactgegevens aangepast!';
    } else {
        $alertMsg = 'Er is een fout opgetreden. Probeer nog eens';
    }
    
    echo "<script>
    window.alert(". $alertMsg .");
    window.location.href='loggedIn.php';
    </script>";
}

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
    </head>
    <body>
        <br><br>
        <div class="container">
            <div class="row">
                <div class="col"></div>
                <div class="col-4 text-center">
                    <?php
                    $x = new Contact();
                    $result = $x->getContact();
                    ?>
                    <form action="contact.php?action=edit" method="post">
                        <div class="form-group">
                            Telefoon: <input type="tel" class="form-control" id="phoneEdit" name="phone" value="<?= $result['phone'] ?>">
                        </div>
                        <div class="form-group">
                            Link<input type="url" class="form-control" id="linkEdit" value="<?= $result['link'] ?>" name="link">
                        </div>
                        <button type="submit" class="btn btn-primary" name="contactEdit">Opslaan</button>
                    </form>
                </div>
                <div class="col"></div>
            </div>
        </div>
    </body>
</html>