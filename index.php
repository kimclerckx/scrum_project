<?php
    //connection to database
    require_once 'Database.php';
    $db = new Database();
    //Select all the nodes with parentID 1 except the first dummy
    $sql = "SELECT * FROM nodes WHERE parentID = 1 AND ID != 1";
    //see custom database file
    $db->executeWithoutParam($sql);
    //Fetch all the data
    $resultSet = $db->resultset();
    $db = null;
?>
<!DOCTYPE html>
<!--
index.php
-->
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favico.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/favico.png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

        <script>
    </script>
    <title>De wegwijzer | oever</title>
</head>
<body>
<header>
    <div class="top">
        <div class="wrapper">
            <div class="top-container">
                <div class="logo"><img src="images/logo-oeverdef.png"></div>
                <div class="site-name"> De oever</div>
            </div>
        </div>
    </div>

</header>

<div class="wrapper">
    <h1>De wegwijzer</h1>
    <!-- BREADCRAMBS DOES NOT WERK!!! I added new version of jQuery and it stopped working -->

    <!-- <div class="breadCrumbHolder module">
                <div id="breadCrumb" class="breadCrumb module">
                    <ul>
                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li>
                            <a href="#">Biocompare Home</a>
                        </li>
                        <li>
                            <a href="#">Product Discovery</a>
                        </li>
                        <li>
                            <a href="#">Life Science Products / Laboratory Supplies</a>
                        </li>
                        <li>
                            <a href="#">Kits and Assays</a>
                        </li>
                        <li>
                            <a href="#">Mutagenesis Kits</a>
                        </li>
                        <li>
                            Mutation Generation System&trade;
                        </li>
                    </ul>
                </div>
            </div> -->
    <div class="node-container">
        <?php
        //Loop through $resultset and create html for each node with content
        foreach ($resultSet as $value) {
        // we create divs with class item and id (from database)
        echo '<div class="item" id="'. $value['ID'].'">';
        echo $value['content'];
        echo '</div>';
        } ?>
    </div>
</div>

<!-- JAVASCRIPT AND JQUERY LIBRARIES -->
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    //fallback if dowloading from CDN is not successful
    window.jQuery || document.write("<script src='Js\/jquery.js'><\/script>");
</script>
-
<!-- jBreadCrumb -->
<script src="js/jquery.easing.1.3.js" type="text/javascript" language="JavaScript"></script>
<script src="js/jquery.jBreadCrumb.1.1.js" type="text/javascript" language="JavaScript"></script>

<!-- Our javascript code -->
<script type="text/javascript">
    var id;
    var string;
    $(document).ready(function() {
        $("#breadCrumb").jBreadCrumb();

        $('.node-container').on('click', '.item', function(){
            // every div with class .item or .text have id, and we give this id to ajax as parent element
            // to retrieve data from database
            id = this.id;

            // here begins the magic
            $.ajax({
                url: 'getContentNodes.php', 
                dataType: 'json',           //we expect JSON array to be returned back
                method: 'get',              //with get method
                data: {id: id},             //give id as parametr 
                success: function (data) {
                    string = '';
                    //loop through elements in JSON array
                    $.each(data, function(index, element) {
                        // if it has children then give .item class, otherwise .text (.item is clickable, .text - no)
                        if(element.hasChild == 1) {
                            string += '<div class= "item" id ="'+ element.ID + '">' + element.content + '</div>';
                        } else {
                            string += '<div class= "text" id ="'+ element.ID + '">' + element.content + '</div>';
                        }
                    });

                    $('.node-container').html(string);
                }
            });
        });
    });
</script>


</body>
</html>
