<?php
require_once '../Database.php';
if (!isset($_SESSION)) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
}
//Perform delete

if (isset($_GET['delete'])) {
    $db = new Database();
    $sql = "DELETE FROM users WHERE ID = :id";
    $db->executeWithParam($sql, array(array(':id', $_GET['delete'])));
    $db = null;
}

// Get users list

$db = new Database();
$email = $_SESSION['email'];
//Avoid deleting admin account 
$sql = "SELECT * FROM users WHERE ID != 1 AND email != :email";
$db->executeWithParam($sql, array(array(':email', $email)));
$user = $db->resultset();
$db =null;
?>
<!-- Including header -->
<?php require_once('include/header.php');
require_once 'include/menu.php';?>

<body>
    <br><br>
    <div class="container">
        <div class="row justify-content-md-center">

            <div class="col-8 ">
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-3"><strong>User ID</strong></div>
                            <div class="col-3"><strong>Email</strong></div>
                            <div class="col-6"><strong>Delete</strong></div>
                        </div>
                    </li>
                    <?php
                    if ($user) {
                        foreach ($user as $value) {
                            ?>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-3"><?php print $value['ID']; ?></div>
                                    <div class="col-3"><?php print $value['email']; ?></div>
                                    <div class="col-6"><a class="btn btn-primary" href="UserDelete.php?delete=<?php print $value['ID']; ?>" onclick="return confirm('Ben je zeker dat je dit user wil verwijderen?');">Delete account</a></div>
                                </div>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <li class="list-group-item">No accounts to be deleted</li>
                        <?php
                    }
                    ?>
                </ul>
            </div>

        </div>
    </div>
</body>
</html>