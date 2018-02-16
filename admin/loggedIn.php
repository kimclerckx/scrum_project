<?php
require_once 'NodeList.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
}

// Create new object
$nodeList = new NodeList();

// If delete button is clicked
if (isset($_GET['action']) && $_GET['action'] == 'delete'){

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

    echo "<script>
    window.alert('Item is verwijderd');
    window.location.href='loggedIn.php';
   </script>";
 }

function buildTree(array $elements, $parentID = 1)
{
    $structure = '<ul class="editor-page">';
    foreach ($elements as $element) {
        if ($element['parentID'] == $parentID) {
            $structure .= "<li>" . $element['content']
                . '<a href="NodeEdit.php?action=add&id=' . $element['ID'] . '"><i class="ion-plus-round"></i></a>' . ' '
                . '<a href="NodeEdit.php?action=edit&id=' . $element['ID'] . '"><i class="ion-edit"></i></a>' . ' '
                . '<a href="loggedIn.php?action=delete&id=' . $element['ID'] . '"><i class="ion-close-round"></i></a>';
            if ($element['hasChild'] == 1) {
                $structure .= buildTree($elements, $element['ID']);
            }
            $structure .= "</li>";
        }
    }
    $structure .= "</ul>";
    return $structure;
}

if (isset($_SESSION['email'])) {
    $welcome = ' Welkom ' . $_SESSION['email'] . ' : je bent nu ingelogd als administrator.';
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
    <link rel="stylesheet" href="../admin/css/admin-style.css">
    <link rel="stylesheet" href="../css/ionicons.min.css">
    <title>Document</title>
</head>
<body>
<br><br>
<div class="text-center">
    <?php
        print $welcome;
    ?>
</div>
<br/><br/>
<!-- Edit contact button-->
<p><a href="contact.php" target="_self">Pas contactgegevens aan </a></p>

<!-- Treeview -->
<?php
    echo buildTree($nodeList->getAllNodes());
?>
<!-- End of Treeview -->
<br/><br/>
<div class="text-center">
    <a class="btn btn-primary" href="logout.php">Logout</a>
    <br/><br/>
    <a class="btn btn-primary" href="passwordChange.php">Wijzig wachtwoord</a>
</div>
</body>
</html>
