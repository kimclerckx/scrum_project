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
    <!-- Including header -->
    <?php require_once('include/header.php'); ?>
    <body>
        <!--Check if user is logged in-->
        <?php
        if (!isset($_SESSION['email'])) {
            header("Location:index.php");
        } ?>
        <!--Menu-->
        <?php require_once 'include/menu.php'; ?>
        <!--Show log records-->
        <div class="headWrapper">
            <form action="logs.php" method="post">
                <select name="aantLogs" id="aantLogs">
                    <option value="25"<?php echo ($_SESSION['aantLogs'] == '25') ? 'selected="selected"' : ''; ?> >25</option>
                    <option value="50"<?php echo ($_SESSION['aantLogs'] == '50') ? 'selected="selected"' : ''; ?> >50</option>
                    <option value="75"<?php echo ($_SESSION['aantLogs'] == '75') ? 'selected="selected"' : ''; ?> >75</option>
                    <option value="100"<?php echo ($_SESSION['aantLogs'] == '100') ? 'selected="selected"' : ''; ?> >100
                    </option>
                </select>
                <input class='btn btn-primary' type="submit" value="Toon">
            </form>
        </div>

        <?php
        $ll = new LogList();
        $logCount = $ll->getLogCount();
        $aantPages = ceil($logCount / $aantLogs);
        $list = $ll->getLogs($aantLogs, $_GET['page']);
        ?>
        <div class="wrapperLogs">
            <span class="box colH text-center">#</span>
            <span class="box colH text-center">Start</span>
            <span class="box colH text-center">Einde</span>
            <span class="box colH text-center">Totale tijd</span>
            <span class="box colH text-center">Laatst bezochte element</span>

            <?php foreach ($list as $log) {
                $datetime1 = new DateTime($log['timestampStart']);
                $datetime2 = new DateTime($log['timestampEnd']);
                $duurtijd = $datetime2->diff($datetime1);
                ?>

                <span class="box col1 text-center"><?php print $log['ID']; ?></span>
                <span class="box col2 text-center"><?php print $log['timestampStart']; ?></span>
                <span class="box col3 text-center"><?php print $log['timestampEnd']; ?></span>
                <span class="box col4 text-center"><?php print $duurtijd->format('%hu %im %ss'); ?></span>
                <span class="box col5 text-center"><?php print $log['content']; ?></span>

            <?php } ?>

        </div>
        <div class="text-center pages">
            <div>
        <?php
        $i = $_GET['page'];
        echo "<a class='btn btn-primary pageButton' href='logs.php?page=" . 1 . "'>Eerste</a>";
        if (($i - 1) > 0) {
            echo "<a class='btn btn-primary pageButton' href='logs.php?page=" . ($i - 1) . "'>Vorige</a>";
        }
        if (($i - 2) > 0) {
            echo "<a class='btn btn-primary pageButton' href='logs.php?page=" . ($i - 2) . "'>" . ($i - 2) . "</a>";
        }
        if (($i - 1) > 0) {
            echo "<a class='btn btn-primary pageButton' href='logs.php?page=" . ($i - 1) . "'>" . ($i - 1) . "</a>";
        }
        echo "<a class='btn btn-primary pageButton' href='logs.php?page=" . $i . "'>" . $i . "</a>";
        if (($i + 1) <= $aantPages) {
            echo "<a class='btn btn-primary pageButton' href='logs.php?page=" . ($i + 1) . "'>" . ($i + 1) . "</a>";
        }
        if (($i + 2) <= $aantPages) {
            echo "<a class='btn btn-primary pageButton' href='logs.php?page=" . ($i + 2) . "'>" . ($i + 2) . "</a>";
        }

        if (($i + 1) <= $aantPages) {
            echo "<a class='btn btn-primary pageButton' href='logs.php?page=" . ($i + 1) . "'>Volgende</a>";
        }
        echo "<a class='btn btn-primary pageButton' href='logs.php?page=" . $aantPages . "'>Laatste</a>";
        ?>
        </div>
    </body>
</html>
