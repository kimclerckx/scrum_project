<?php

require_once 'NodeList.php';
$updated = false;
if (isset($_GET["action"]) && ($_GET["action"] == "replace")) {
    $edit_data = $_POST['content'];
    $edit = new NodeList();
    $edit->upDateNode($_GET["id"], $edit_data);
    $updated = true;
    header("location:loggedIn.php");
}

$node = new NodeList();
$content = $node->getContentByID($_GET["id"]);
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
        <div class="col-11">
            <div class="form-group">
                <form action="NodeEdit.php?action=replace&id=<?php print ($_GET["id"]); ?>" method="post">
                <textarea name="content" id="ckeditor">
                  <?php
                  print $content['content'];
                  ?>  
                </textarea>
                    <script>
                        CKEDITOR.replace('ckeditor');
                    </script>
                    <input class="btn btn-primary spacer" type="submit" value="Opslaan">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

