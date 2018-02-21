<?php
require_once 'LogList.php';
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}

if (isset($_POST['aantLogs']) || (isset($_SESSION['aantLogs']))) {
    $_SESSION['aantLogs'] = (isset($_POST['aantLogs']) ? $_POST['aantLogs'] : $_SESSION['aantLogs']);
} else {
    $_SESSION['aantLogs'] = 25;
}
$aantLogs = $_SESSION['aantLogs'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logs</title>
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
<!--Check if user is logged in-->
<?php
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
} else { ?>
    <div class="header">
        <a class='btn btn-primary' href='logout.php'>Logout</a>
    </div>
<?php } ?>
<div>
    <form class="form-horizontal" action="exportToCSV.php" method="post" name="upload_excel"
          enctype="multipart/form-data">
        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                <input type="submit" name="Export" class="btn btn-success" value="Exporteer naar Excel"/>
            </div>
        </div>
    </form>
</div>
<!--Show log records-->
<div>
    <form action="logs.php" method="post">
        <select name="aantLogs" id="aantLogs">
            <option value="25"<?php echo ( $_SESSION['aantLogs'] == '25') ? 'selected="selected"' : ''; ?> >25</option>
            <option value="50"<?php echo ($_SESSION['aantLogs'] == '50') ? 'selected="selected"' : ''; ?> >50</option>
            <option value="75"<?php echo ($_SESSION['aantLogs'] == '75') ? 'selected="selected"' : ''; ?> >75</option>
            <option value="100"<?php echo ($_SESSION['aantLogs'] == '100') ? 'selected="selected"' : ''; ?> >100</option>
        </select>
        <input type="submit" value="Toon">
    </form>
</div>

<?php
$ll = new LogList();
$logCount = $ll->getLogCount();
$aantPages = ceil($logCount / $aantLogs);
$list = $ll->getLogs($aantLogs, $_GET['page']);
?>
<div class="wrapperLogs">
    <span class="box colH">#</span>
    <span class="box colH">Start</span>
    <span class="box colH">Einde</span>
    <span class="box colH">Totale tijd</span>
    <span class="box colH">Laatst bezochte element</span>

    <?php foreach ($list as $log) {
        $datetime1 = new DateTime($log['timestampStart']);
        $datetime2 = new DateTime($log['timestampEnd']);
        $duurtijd = $datetime2->diff($datetime1);
        ?>

        <span class="box col1"><?php print $log['ID']; ?></span>
        <span class="box col2"><?php print $log['timestampStart']; ?></span>
        <span class="box col3"><?php print $log['timestampEnd']; ?></span>
        <span class="box col4"><?php print $duurtijd->format('%hu %im %ss'); ?></span>
        <span class="box col5"><?php print $log['content']; ?></span>

    <?php } ?>

    <?php
    for ($i = 1; $i <= $aantPages; $i++) {
        echo "<a href='logs.php?page=" . $i . "'>" . ($aantLogs * ($i - 1)) . '-' . ($aantLogs * $i) . "</a>";
    }
    ?>

</div>
</body>
</html>
