<?php
if(!isset($_SESSION)) {
    session_start();
}

?>

<div class="header text-center">
    <p>Welkom <?= $_SESSION['email'] ?>: je bent nu ingelogd als administrator.</p>
    <div>
    <a class='btn btn-primary' href='contact.php' target='_self'>Pas contactgegevens aan </a>
    <a class='btn btn-primary' href='passwordChange.php'>Wijzig wachtwoord</a>
    <a class='btn btn-primary' href='logs.php'>Logs</a>
    <a class='btn btn-primary' href='logout.php'>Logout</a>
    </div>
</div>
