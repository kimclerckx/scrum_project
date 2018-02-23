<?php
/*Creation of admin user
require_once '../Database.php';
$db = new Database();
$email = 'admin@admin.com';
$password = 'admin';
$sql = 'INSERT INTO users ( email, password)
        VALUES (:email, :password)';

$passwordHashed = password_hash($password, PASSWORD_BCRYPT);
$db->executeWithParam ($sql, array(array(':email', $email), array('password', $passwordHashed)));
$db = null;*/
session_start();
require_once '../Database.php';
$db = new Database();
$errors = [];
if (isset($_SESSION['email'])) {
    header("Location:loggedIn.php");
}

//LOGIN PROCESS//
//1. Check is login button is clicked
if (isset($_POST['login'])) {

    //2. Trim $_POST to remove accidental extra whitespace and put in variable
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;

    //3. Check if fields are empty
    if (empty($email)) {
        $errors[] = "E-mail is verplicht!";
    }
    if (empty($password)) {
        $errors[] = "Wachtwoord is verplicht!";
    }
    //4. Validate email when there are no errors
    if (count($errors) == 0) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "E-mail is niet geldig!";
        } else {
            //5. Check to see if email exists in database
            $sql = "SELECT * FROM users WHERE email = :email";
            $db->executeWithParam($sql, array(array(':email', $email)));
            //6. Check if email is found in database
            if ($db->rowCount() == 0) {
                $errors[] = "Sorry, gebruiker met e-mailadres " . $email . " bestaat niet in onze databank.";
            }
        }
        if (count($errors) == 0) {
            $results = $db->single();
            //7. Check if passwords match
            if (!password_verify($_POST['password'], $results['password'])) {
                $errors[] = "Wachtwoord voor " . $email . " is niet correct.";
            } else {
                $_SESSION['email'] = $results['email'];
                header("Location:loggedIn.php");
            }
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
    <link rel="stylesheet" href="css/admin-style.css">
    <title>De Wegwijzer Login</title>
</head>
<body>
<br><br>
<div class="container">
    <div class="row">
        <div class="col"></div>
        <div class="col-4 text-center">
            <form action="index.php" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Admin e-mail" name="email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Wachtwoord</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Admin wachtwoord" name="password">
                </div>
                <button type="submit" class="btn btn-primary" name="login">Log in</button>
            </form>
            <br>
            <a class="btn btn-primary" href="passwordReset.php">Reset wachtwoord</a>
            <br><br>
            <p class ="text-center errrors"><?php echo implode("<br><br>", $errors);?></p>
        </div>
        <div class="col"></div>
    </div>
     
</div>

</body>
</html>

