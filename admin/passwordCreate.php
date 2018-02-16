<?php
session_start();
require_once '../Database.php';
$db = new Database();
$errors = [];
//php for password change
//1. Check is Password Change button is clicked
if (isset($_POST['create'])) {

    //2. Trim $_POST to remove accidental extra whitespace from inputs and put in variable
    $passwordNew = !empty($_POST['newPassword']) ? trim($_POST['newPassword']) : null;
    $passwordConfirmNew = !empty($_POST['confirmNewPassword']) ? trim($_POST['confirmNewPassword']) : null;

    //3. Check if fields are empty
    if (empty($passwordNew)) {
        $errors[] = "Wachtwoord is verplicht.";
    }
    if (empty($passwordConfirmNew)) {
        $errors[] = "Wachtwoord herhalen is verplicht.";
    }

    if (count($errors) == 0) {
        //4. Check if passwords match and update password in the database if true
        if ($passwordNew !== $passwordConfirmNew) {
            $errors[] = "De ingevoerde wachtwoorden zijn niet gelijk, probeer opnieuw.";
        } else {
            $sql = 'UPDATE users SET password = :password WHERE ID = :id';
            $db->executeWithParam($sql, array(array(':password', password_hash($passwordConfirmNew, PASSWORD_BCRYPT)), array(':id', $_SESSION['user_id_reset_pass'])));
            $db = null;
            require_once 'logout.php';
        }
    }
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
    <title>Nieuw wachtwoord</title>
</head>
<body>
<br><br>
<div class="container">
    <div class="row">
        <div class="col"></div>
        <div class="col-4 text-center">
            <form action="passwordCreate.php" method="post">
                <div class="form-group">
                    <label for="exampleInputPassword1">Nieuw wachtwoord</label>
                    <input type="password" class="form-control" id="exampleInputPassword1"
                           placeholder="Je nieuwe wachtwoord"
                           name="newPassword">
                    <small id="emailHelp" class="form-text text-muted">Voer je nieuwe wachtwoord in.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Nieuw wachtwoord bevestigen</label>
                    <input type="password" class="form-control" id="exampleInputPassword1"
                           placeholder="Herhaal je nieuwe wachtwoord"
                           name="confirmNewPassword">
                    <small id="emailHelp" class="form-text text-muted">Bevestig je nieuwe wachtwoord.</small>
                </div>
                <button type="submit" class="btn btn-primary" name="create">Maak nieuw wachtwoord</button>
            </form>
        </div>
        <div class="col"></div>
    </div>
</div>
<br/>
<!-- implode —> Join array elements with a string and use separator <br><br> in this case (showing the different error messages under each other)-->
<p class="text-center"><?php echo implode("<br><br>", $errors); ?></p>
</body>
</html>
