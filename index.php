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
    <link rel="stylesheet" href="vendors/asBreadcrumbs/asBreadcrumbs.min.css">
    <link rel="stylesheet" href="vendors/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

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

    <!--Here begins the list for the breadcrumbs    -->
    <ol class="breadcrumb">
        <li class="active">Home</li>
    </ol>

    <!--Generate divs for the main page   -->
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
<script src="vendors/asBreadcrumbs/jquery-asBreadcrumbs.min.js"></script>
<script src="vendors/bootstrap.min.js"></script>
<script>
    //fallback if downloading from CDN is not successful
    window.jQuery || document.write("<script src='Js\/jquery.js'><\/script>");
</script>

<!-- Our javascript code -->
<script type="text/javascript">
    var id;
    var string;
    var x, parent;

    <!--   If document is ready, perform the code    -->
    $(document).ready(function() {

        <!--   Using Jquery library for breadcrumbs   -->
        $('.breadcrumb').asBreadcrumbs({
            namespace: 'breadcrumb'
        });

        <!--   If we click on menu divs   -->
        $('.node-container').on('click', '.item', function(){

            <!--Give li elements the class : active -->
            $( "li" ).last().removeClass('active');

            <!-- Retrieve the text from clicked li -->
            x = $( "li" ).last().text();

            <!-- Add to the clicked li element a element -->
            $( "li" ).last().html('<a href="" id="' + this.id +'">' + x +'</a>');

            <!-- Add li element to the breadcrumb -->
             string = '<li class="active">' + $(this).text() + '</li>';
             $('.breadcrumb').append(string);

            // every div with class .item or .text have id, and we give this id to ajax as parent element
            // to retrieve data from database
            id = this.id;

            // here begins the magic
            $.ajax({
                url: 'getContentNodes.php',
                dataType: 'json',           //we expect JSON array to be returned back
                method: 'get',              //with get method
                data: {id: id, param: 1},   //give id as parameter and also param is parameter
                // param 1 = clicked on divs & param 2 = clicked on breadcrumb
                success: onSuccess
            });
        });

        <!-- If you click on a element in li in breadcrumbs  -->
        $('ol').on('click', 'li a', function(e) {

            <!-- Stop the natural behaviour of a elements = will not go to the link in href-->
            e.preventDefault();

            <!-- Find all the next siblings of parent element (li) of clicked a element -->
            $(this).parent().nextAll().remove();

            <!-- Make a copy of text in a element -->
            x = $(this).html();

            parent = $(this).parent();
            <!-- Remove a element from li -->
            $(this).remove();
            <!-- Set the text of li element to text from a element -->
            parent.text(x);

            <!-- Every a element has id -->
            id = this.id;

            $.ajax({
                url: 'getContentNodes.php',
                dataType: 'json',           //we expect JSON array to be returned back
                method: 'get',              //with get method
                data: {id: id, param: 2},   //give id as parametr
                success: onSuccess
            })
        });
        <!-- This is the function to perform if ajax was successful performed -->
        function onSuccess(data) {
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
</script>


</body>
</html>
