<?php
require_once 'NodeList.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
} else {
    echo "Welkom {$_SESSION['email']} : je bent nu ingelogd als administrator.";
}

// Create new object
$nodeList = new NodeList();

// If delete button is clicked
if (isset($_GET['action']) && $_GET['action'] == 'delete') {

    // Retrieve all nodes from database 
    $nodes = $nodeList->getAllNodes();
    // Use recursive function to get the id of all children elements of clicked item
    $nodeList->toBeDeleted($nodes, $_GET['id']);
    // Push ids into array
    $arrToDelete = $nodeList->toDelete;
    // Push the id of the clicked element itself into array
    array_push($arrToDelete, $_GET['id']);

    // Delete nodes
    $nodeList->deleteNodes($arrToDelete);

    echo ("<script>
    window.alert('Item is verwiderd.');
    window.location.href='loggedIn.php';
    </script>");
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- BOOTSTRAP CSS FONT -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- IONICONS FONT -->
    <link rel="stylesheet" href="../vendors/ionicons/css/ionicons.min.css">
    <!-- OUR STYLE FOR ADMIN -->
    <link rel="stylesheet" href="../admin/css/admin-style.css">

    <title> Admin Panel </title>
</head>

<body>
    <!-- Edit contact button-->
    <p><a href="contact.php" target="_self">Pas contactgegevens aan </a></p>

    <!-- Treeview -->
    <?php
        echo $nodeList->buildTree($nodeList->getAllNodes());
    ?>
    <!-- End of Treeview -->

    <div class="text-center">
        <a class="btn btn-primary" href="logout.php">Logout</a>
        <a class="btn btn-primary" href="passwordChange.php">Wijzig wachtwoord</a>
    </div>

    <!-- JAVASCRIPT + JQUERY for Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type='text/javascript'>
    // This function we use in our link to delete item
        function confirmDelete()
        {
            return confirm("Are you sure you want to delete this?");
        }
    </script>
</body>
</html>
