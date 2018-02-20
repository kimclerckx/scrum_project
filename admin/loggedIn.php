<?php
require_once 'NodeList.php';
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
} else {
    echo '<div class="header">';
        echo "<p>Welkom {$_SESSION['email']} : je bent nu ingelogd als administrator.</p>";
        echo "<a class='btn-primary' href='logs.php'>Logs</a>";
        echo "<a class='btn btn-primary' href='logout.php'>Logout</a>";
    echo '</div>';
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

<!-- Including header -->
<?php require_once ('include/header.php'); ?>
<body>
    <!-- Treeview -->
    <div class="jumbotron">
        <a class="btn btn-primary" href="NodeEdit.php?action=add&id=1">Add root node </a>
        <?php
            echo $nodeList->buildTree($nodeList->getAllNodes());
        ?>
    </div>
    <!-- End of Treeview -->

    <div class="text-center">
        <a class="btn btn-primary" href="contact.php" target="_self">Pas contactgegevens aan </a>
        <a class="btn btn-primary" href="passwordChange.php">Wijzig wachtwoord</a>
    </div>

    <!-- Including all the scripts -->
    <?php require_once('include/scripts_footer.php') ?>

    <script type='text/javascript'>
    // This function we use in our link to delete item
        function confirmDelete()
        {
            return confirm("Are you sure you want to delete this?");
        }
    </script>
</body>
</html>
