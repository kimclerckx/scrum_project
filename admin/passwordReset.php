<?php
session_start();
require_once '../Database.php';
require_once '../functions.php';
$errors = [];

//php for password change
//1. Check is Password Reset button is clicked
if (isset($_POST['reset'])) {

//2. Check if fields are empty
    if (empty($_POST['email'])) {
        $errors[] = "Email is verplicht.";
    } else {

        //3. Trim $_POST to remove accidental extra whitespace from inputs and put in variable
        $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    }

    //4. Validate email when there are no errors
    if (count($errors) == 0) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Geen geldig email adres.";
        } else {

            //5. Check to see if email exists in database
            $db = new Database();
            $sql = "SELECT * FROM users WHERE email = :email";
            $db->executeWithParam($sql, array(array(':email', $email)));

            //6. Check if email is found in database
            if ($db->rowCount() == 0) {
                $errors[] = "De gebruiker met e-mailadres : " . $email . " bestaat niet in onze database.";
            }
        }
        if (count($errors) == 0) {
            $results = $db->single();

            //7. Check if passwords match
            $userId = $results['ID'];

            //Create a secure token for this forgot password request.
            $token = openssl_random_pseudo_bytes(16);
            $token = bin2hex($token);
            $date = date("Y-m-d H:i:s");

            //Insert the request information
            //into our password_reset_request table.
            //The SQL statement.

            $insertSql = "INSERT INTO password_reset_request (user_ID, date_requested, token) VALUES (:user_id, :date_requested, :token)";

            //Prepare our INSERT SQL statement.
            //Execute the statement and insert the data.

            $db->executeWithParam($insertSql, array(array(':user_id', $userId), array(':date_requested', $date), array(':token', $token)));

            //Get the ID of the row we just inserted.
            $passwordRequestId = $db->lastInsertId();

            //Create a link to the URL that will verify the
            //forgot password request and allow the user to change their
            //password.
            $verifyScript = $root_URL.'admin/passwordForgot.php';

            //The link that we will send the user via email.
            $linkToSend = $verifyScript . '?uid=' . $userId . '&id=' . $passwordRequestId . '&t=' . $token;

            //Print out the email for the sake of this tutorial.
            echo $linkToSend;

            $to      = 'kim.clerckx@gmail.com';
            $subject = 'the subject';
            $message = $linkToSend;
            $headers = 'From: webmaster@example.com' . "\r\n" .
                'Reply-To: webmaster@example.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
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
</head>
<body>
<br><br>
<div class="container">
    <div class="row">
        <div class="col"></div>
        <div class="col-4 text-center">
            <form action="passwordReset.php" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Je account email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1"
                           placeholder="Voer je email in" name="email">
                    <small id="emailHelp" class="form-text text-muted">Voer het e-mailadres van een bestaande account in.
                    </small>
                </div>
                <button type="submit" class="btn btn-primary" name="reset">Reset wachtwoord</button>
                <a class='btn btn-primary' href='index.php'>Terug</a>
            </form>
            
        </div>
        <div class="col"></div>
    </div>
</div>
<br/>
<!-- implode —> Join array elements with a string and use seperator <br><br> in this case (showing the different error messages under each other)-->
<p class="text-center errors"><?php echo implode("<br><br>", $errors); ?></p>
</body>
</html>