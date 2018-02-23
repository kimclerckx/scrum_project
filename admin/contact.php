<?php
require_once '../Database.php';
if (!isset($_SESSION)) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
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
        $sql = 'UPDATE contact SET phone = :phone, link = :link WHERE ID = 3';
        $db->executeWithParam($sql, array(array(':phone', $phone), array(':link', $link)));
        $db = null;
    }
}

$contact = new Contact();

if (isset($_POST['contactEdit'])) {
    $contact->updateContact($_POST['phone'], $_POST['link']);
    echo ("<script>
    window.alert('Wijzigingen opgeslagen');
    window.location.href='loggedIn.php';
    </script>");
}


?>

<!-- Including header -->
<?php require_once('include/header.php');
require_once 'include/menu.php';?>
<body>
    <h2>Pas contactgegevens aan</h2>
    <div class="container">
        <div class="col-4 mx-auto text-center">
            <?php
                $result = $contact->getContact();
            ?>
            <form action="contact.php" method="post">
                <div class="form-group">
                    Telefoon: (xxxx-xx-xxx) <input type="tel" pattern="[0-9]{4}-[0-9]{2}-[0-9]{3}" classghfg="form-control" id="phoneEdit" name="phone" required value="<?= $result['phone'] ?>">
                <span class="validity"></span>
                </div>
                <div class="form-group">
                    Link<input type="url" class="form-control" id="linkEdit" value="<?= $result['link'] ?>" name="link" required>
                </div>
                <button type="submit" class="btn btn-primary" name="contactEdit">Opslaan</button>
                <a href="loggedIn.php" class="btn btn-primary">Terug</a>
            </form>
        </div>
    </div>
</body>
</html>
