<?php
    // Connection to database
    require_once 'Database.php';
    require_once 'logs.php';

    $db = new Database();
    // Contact data retrieving
    $sql = 'SELECT * FROM contact';
    $db->executeWithoutParam($sql);
    $result= $db->single();
    $db = null;
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
    <link href="https://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet">
    
    <!-- Breadcrumns CSS -->
    <link rel="stylesheet" href="vendors/asBreadcrumbs/css/asBreadcrumbs.css">
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="vendors/Bootstrap_3.3.7_for_Breadcrumbs/bootstrap.min.css">
    <!-- IONICONS FONT -->
    <link rel="stylesheet" href="vendors/ionicons/css/ionicons.min.css">
    <!-- OUR STYLES -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/addtohomescreen.css">

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
    <!--set a web app capable website-->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
  
    <link rel="manifest" href="/manifest.json">
    <!-- END -> LINKS AND META FOR THE APP VERSION -->

    <title> De wegwijzer | oever </title>
</head>
<body>
<header>
    <div class="top">
        <div class="wrapper">
            <div class="top-container">
                <div class="site-name"> De wegwijzer</div>
                <div class="logo"><a href="" name="1"><img src="images/logo-oeverdef.png"></a></div>
            </div>
        </div>
    </div>
</header>
    
<div class="wrapper">
    <!-- BREADCRUMBS-->
    <div id="bc1" class="btn-group btn-breadcrumb">
        <a href="#" class="btn btn-default" id="1"><i class="ion-ios-home-outline"></i></a>
    </div>

    <!-- Generate divs for the main page   -->
    <div class="node-container"></div>

    <!-- Create back button -->
    <div class="navigation">
        <div class="back"><a href=""><i class="ion-ios-arrow-back"></i></a></div>
        <div class="home"><a href="" name="1"> <i class="ion-ios-home-outline"></i></a></div>
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

<!--Add to homescreen option bar-->
<script src="Js/addtohomescreen.js"></script>
<script>
    var ath = addToHomescreen({
    skipFirstVisit: false,              // show at first access
    icon: false,                           // laat in de message een icoontje van De Oever zien
    startDelay: 0,                        // display the message right away
    lifespan: 0,                            // do not automatically kill the call out
    displayPace: 0,                     // do not obey the display pace
    privateModeOverride: true,     // show the message in private mode
    maxDisplayCount: 1             // do not obey the max display count
    });
</script>


<!-- Our javascript code -->
<script type="text/javascript">   
    /* If document is ready, perform the code */
    $(document).ready(function () {
        var id, string, x, parent, phone, link, ph, url;

        $.ajax({
            url: 'getContentNodes.php',
            dataType: 'json',           //we expect JSON array to be returned back
            method: 'get',              //with get method
            data: {id: 1, param: 1},   //give id as parameter and also param is parameter
            // param 1 = clicked on divs & param 2 = clicked on breadcrumb
            success: onSuccess
        });


        /* ---------- Creating buttons for bellen and chatten  ---------- */
        phone = <?php echo $result['phone']; ?>;
        link = "<?php echo $result['link']; ?>";

        ph = '<a href="tel:'+ phone +'" class="phone"> Bel met een medewerker </a>';
        url = '<a href="'+ link +'" class="url" target="_blank"> Chat met een medewerker </a>';

       
        /* ---------- Clicking on MENU DIVS  ---------- */
        $('.node-container').on('click', '.item', function () {

            /* Add li element to the breadcrumb */
            string = '<a href="" id="'+  this.id + '" class="btn btn-default"><div>' + $(this).text() + '</div></a>';

            // Every time we click on menu divs, change name attribute of back button to id of this div

            x = $('#bc1 a').last().attr('id');
            $('.back a').attr('name', x);

            $('#bc1').append(string);
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


        /* ---------- Clicking on <a> of BREADCRUMBS  ---------- */
        $('#bc1').on('click', 'a', function (e) {
            // Stop the natural behaviour of a elements = will not go to the link in hre
            e.preventDefault();

            // Find all the next siblings of clicked a element and remove it
            $(this).nextAll().remove();

            x = $('#bc1 a').last().prev().attr('id');
            $('.back a').attr('name', x);
            
            // Every <a> element has id
            id = this.id;

            $.ajax({
                url: 'getContentNodes.php',
                dataType: 'json',           // we expect JSON array to be returned back
                method: 'get',              // with get method
                data: {id: id, param: 1},   // give id as parametr
                success: onSuccess
            })
        });

        /* ---------- CLICKING BACK, HOME, OR LOGO ---------- */
        $('.wrapper').on('click', '.back a, .home a, .logo a', function (e) {
            e.preventDefault();
            // 'a' element in div.back has attribute name met value = id
            // so we take this id and then search for 'a' element with the same id in our breadcrumps
            // then we trigger click event on this 'a' element in breadcrumps
            id = $(this).attr('name');
            x = $('#bc1 a[id=' + id + ']');
            x.trigger('click');
        });

    
        /* ---------- FUNCTION TO PERFORM AFTER AJAX IS PERFORMD ---------- */
        function onSuccess(data) {
            string = '';
            var id_parent;
            // loop through elements in JSON array
            $.each(data, function (index, element) {
                id_parent = element.parentID; // this we need to do to give parent_id of clicked element to ajax to update database

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

            // first .navigation is not visible, but if it is not root node - visible
            if (id_parent == 1) {
                $('.navigation').css('display', 'none');
            } else {
                $('.navigation').css('display', 'flex');
            } 

            $.ajax({
                url: 'logs.php',
                method: 'get',            // with get method
                data: {id: id_parent, param: 2},   // give id as parameter and also param is parameter
            });
        }
    });
</script>
</body>
</html>
