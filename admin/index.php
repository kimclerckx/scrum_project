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
        $errors[] = "Email is required!";
    }
    if (empty($password)) {
        $errors[] = "Password is required!";
    }
    //4. Validate email when there are no errors
    if (count($errors) == 0) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email is not valid!";
        } else {
            //5. Check to see if email exists in database
            $sql = "SELECT * FROM users WHERE email = :email";
            $db->executeWithParam($sql, array(array(':email', $email)));
            //6. Check if email is found in database
            if ($db->rowCount() == 0) {
                $errors[] = "Sorry, user with email : " . $email . " doesn't exist in our database";
            }
        }
        if (count($errors) == 0) {
            $results = $db->single();
            //7. Check if passwords match
            if (!password_verify($_POST['password'], $results['password'])) {
                $errors[] = "Password for " . $email . " is not correct";
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
    <title>Admin Login</title>
</head>
<body>
<br><br>
<div class="container">
    <div class="row">
        <div class="col"></div>
        <div class="col-4 text-center">
            <form action="index.php" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                           placeholder="Enter email" name="email">
                    <small id="emailHelp" class="form-text text-muted">Please input your admin login email.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                           name="password">
                    <small id="emailHelp" class="form-text text-muted">Please input your admin login password.</small>
                </div>
                <button type="submit" class="btn btn-primary" name="login">Login</button>
            </form>
            <br><br>
            <a class="btn btn-primary" href="passwordReset.php">Reset wachtwoord</a>
        </div>
        <div class="col"></div>
    </div>
</div>
</body>
</html>

