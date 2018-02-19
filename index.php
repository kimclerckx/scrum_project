<?php
    // Connection to database
    require_once 'Database.php';
    $db = new Database();
    // Select all the nodes with parentID 1 except the first dummy
    $sql = "SELECT * FROM nodes WHERE parentID = 1 AND ID != 1";
    $db->executeWithoutParam($sql);
    $resultSet = $db->resultset();

    // Contact data retrieving
    $sql = 'SELECT * FROM contact';
    $db->executeWithoutParam($sql);
    $result= $db->single();
    $db = null;

    require_once 'logs.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favico.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/favico.png">
    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel="stylesheet">
    <!-- Breadcrumns CSS -->
    <link rel="stylesheet" href="vendors/asBreadcrumbs/css/asBreadcrumbs.css">
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="vendors/Bootstrap_3.3.7_for_Breadcrumbs/bootstrap.min.css">
    <!-- IONICONS FONT -->
    <link rel="stylesheet" href="vendors/ionicons/css/ionicons.min.css">
    <!-- OUR STYLES -->
    <link rel="stylesheet" href="css/style.css">
    <!-- START -> LINKS AND META FOR THE APP VERSION -->
    <link rel="apple-touch-icon" sizes="57x57" href="images/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="images/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="images/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="images/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="images/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="images/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="images/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="images/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicons/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="images/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="manifest" href="/manifest.json">
    <!-- END -> LINKS AND META FOR THE APP VERSION -->

    <title> De wegwijzer | oever </title>
</head>
<body>
<header>
    <div class="top">
        <div class="wrapper">
            <div class="top-container">
                <div class="logo"><a href="" name="<?php echo $resultSet[0]['ID']; ?>"><img src="images/logo-oeverdef.png"></a></div>
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
        <!-- <li><a>Text</a></li> -->
    </ol>

    <!--Generate divs for the main page   -->
    <div class="node-container">
        <?php
        $id_home = $resultSet[0]['ID'];

        //Loop through $resultset and create html for each node with content
        foreach ($resultSet as $value) {
            // we create divs with class item and id (from database)
            echo '<div class="item" id="' . $value['ID'] . '">';
            echo $value['content'];
            echo '</div>';
        } ?>
    </div>

    <!-- Create back button -->
    <div class="navigation">
        <div class="back"><a href=""><i class="ion-ios-arrow-back"></i></a></div>
        <div class="home"><a href="" name="<?php echo $id_home; ?>"> <i class="ion-ios-home-outline"></i> </a></div>
    </div>
</div>

<!-- JAVASCRIPT AND JQUERY LIBRARIES -->
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Breadcrumns jquery -->
<script src="vendors/asBreadcrumbs/jquery-asBreadcrumbs.min.js"></script>
<!-- Bootstrap js -->
<script src="vendors/Bootstrap_3.3.7_for_Breadcrumbs/bootstrap.min.js"></script>
<script>
    //fallback if downloading from CDN is not successful
    window.jQuery || document.write("<script src='Js\/jquery.js'><\/script>");
</script>

<!-- Our javascript code -->
<script type="text/javascript">   
    /* If document is ready, perform the code */
    $(document).ready(function () {
        var phone = <?php echo $result['phone']; ?>;
        var link = "<?php echo $result['link']; ?>";
        // making to <a> for phone and link to chat
        var ph = '<a href="tel:'+ phone +'" class="phone"> Bel met een medewerker </a>';
        var url = '<a href="'+ link +'" class="url"> Chat met een medewerker </a>';

        var id, string, x, parent;
        
        /* Using Jquery library for breadcrumbs */
        $('.breadcrumb').asBreadcrumbs({
            namespace: 'breadcrumb'
        });
        
        /* If we click on menu divs */
        $('.node-container').on('click', '.item', function () {
            /* Give li elements the class : active */
            $("li").last().removeClass('active');
            /* Retrieve the text from clicked li */
            x = $("li").last().text();
            /* Add to the clicked li element a element */
            $("li").last().html('<a href="" id="' + this.id + '">' + x + '</a>');
            /* Add li element to the breadcrumb */
            string = '<li class="active">' + $(this).text() + '</li>';
            $('.breadcrumb').append(string);
            // every div with class .item or .text have id, and we give this id to ajax as parent element
            // to retrieve data from database

            id = this.id;

            // Every time we click on menu divs, change name attribute of back button to id of this div
            $('.back a').attr('name', id);

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


        // If you click on a element in li in breadcrumbs 
        $('ol').on('click', 'li a', function (e) {
            // Stop the natural behaviour of a elements = will not go to the link in hre
            e.preventDefault();
            // Find all the next siblings of parent element (li) of clicked a element
            $(this).parent().nextAll().remove();
            // Make a copy of text in a element
            x = $(this).html();
            parent = $(this).parent();
            // Remove a element from li
            $(this).remove();
            // Set the text of li element to text from a element
            parent.text(x);
            
            // Every a element has id
            id = this.id;
            
            // if 'a' element in breadcrumps was clicked, we need to change name attribute in 'a' elemnt in back button
            id_1 = parent.prev().children().attr('id');
            $('.back a').attr('name', id_1);

            $.ajax({
                url: 'getContentNodes.php',
                dataType: 'json',           // we expect JSON array to be returned back
                method: 'get',              // with get method
                data: {id: id, param: 2},   // give id as parametr
                success: onSuccess
            })
        });

        // When back or home button is clicked
        $('.wrapper').on('click', '.back a, .home a', function (e) {
            e.preventDefault();
            // 'a' element in div.back has attribute name met value = id
            // so we take this id and then search for 'a' element with the same id in our breadcrumps
            // then we trigger click event on this 'a' element in breadcrumps
            id = $(this).attr('name');
            x = $('li a[id=' + id + ']');
            x.trigger('click');
        });

    
        // This is the function to do if ajax was successful performed
        function onSuccess(data) {
            string = '';
            var id_element;
            // loop through elements in JSON array
            $.each(data, function (index, element) {
                id_element = element.parentID; // this we need to do to give parent_id of clicked element to ajax to update database

                // if it has children then give .item class, otherwise .text (.item is clickable, .text - no)
                if (element.hasChild == 1) {
                    string += '<div class= "item" id ="' + element.ID + '">' + element.content + '</div>';
                } else {
                    if (element.button == 0) {
                        string += '<div class= "text" id ="'+ element.ID + '">' + element.content + '</div>';
                    } else if (element.button == 1) {
                        string += '<div class= "text" id ="'+ element.ID + '">' + element.content + ph + '</div>';
                    } else if (element.button == 2) {
                         string += '<div class= "text" id ="'+ element.ID + '">' + element.content + url + '</div>';
                    } else {
                        string += '<div class= "text" id ="'+ element.ID + '">' + element.content + ph + url + '</div>';      
                    }    
                }
            });
            $('.node-container').html(string);


            $.ajax({
                url: 'logs.php',
                method: 'get',            //with get method
                data: {id: id_element},   //give id as parameter and also param is parameter
            });
        }
    });
</script>
</body>
</html>