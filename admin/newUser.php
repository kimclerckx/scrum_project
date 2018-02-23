<?php
require '../Database.php';
session_start();
$db = new Database();
//Good practice to declare arrays for readability
$errors = [];

//REGISTRATION PROCESS//
//1. Check is register button is clicked
if (isset($_POST['register'])) {

    //2. Trim $_POST to remove accidental extra whitespace and put in variable
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $passwordConfirm = !empty($_POST['passwordConfirm']) ? trim($_POST['passwordConfirm']) : null;

    //3. Check if fields are empty

    if (empty($email)) {
        $errors[] = "E-mailadres is verplicht";
    }
    if (empty($password)) {
        $errors[] = "Wachtwoord is verplicht";
    }
    if (empty($passwordConfirm)) {
        $errors[] = "Herhaal je wachtwoord";
    }
    //only continue when there are no errors
    if (count($errors) == 0) {

        //5. Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "E-mailadres is niet geldig";
        } else {
            // 6. Check if user with this email already exists
            $db = new Database();
            $sql = 'SELECT * FROM users WHERE email = :email';
            $db->query($sql);
            $db->bind(':email', $email);
            $db->execute();
            if ($db->rowCount() > 0) {
                $errors[] = "Dit e-mailadres is al in gebruik";
            }
        }
        // 6) Check if passwords match
        if ($password != $passwordConfirm) {
            $errors[] = "Wachtwoorden zijn niet identiek";
        }
        //7. If no errors -> Enter the new user in the database
        if (count($errors) == 0) {
            $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
            $db->query($sql);
            $db->bind(':email', $email);
            $db->bind(':password', password_hash($password, PASSWORD_BCRYPT));

            if ($db->execute()) {
                $message = 'Nieuwe gebruiker aangemaakt';
                header('Location: index.php');
            } else {
                $message = 'Er is een fout opgetreden bij het aanmaken van een nieuwe gebruiker';
            }
            $db = null;
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registreer een nieuwe gebruiker</title>
    <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="header">
        <a href="index.php"><img src="../images/logo-oeverdef.png"></a>
    </div>

    <?php if (!empty($message)) : ?>
        <p><?= $message ?></p>
    <?php endif; ?>
    <h2>Registreer een nieuwe gebruiker</h2>

    <div class="container">
        <div class="row">
            <div class="col"></div>
                <div class="col-4 text-center">
                    <form action="newUser.php" method="post">
                        <div class="form-group">
                            <label for="email">E-mailadres</label>
                            <input type="text" class="form-control" id="email" placeholder="Voer een geldig e-mailadres in" name="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Wachtwoord</label>
                            <input type="password" class="form-control" id="password" placeholder="Kies wachtwoord" name="password">
                        </div>
                        <div class="form-group">
                            <label for="passwordCheck">Wachtwoord bevestigen</label>
                            <input type="password" class="form-control" id="passwordConfirm" placeholder="Herhaal wachtwoord" name="passwordConfirm">
                        </div>
                        <button type="submit" class="btn btn-primary" value="register" name="register">Gebruiker aanmaken</button>
                    </form>
                </div>
            <div class="col"></div>
        </div>
    </div>
    <br/>
    <a class="btn" href="index.php">Terug</a>
    <br/>
    <!-- implode —> Join array elements with a string and use seperator <br><br> in this case (showing the different error messages under each other)-->
    <p><?php echo implode("<br><br>", $errors); ?></p>
</body>
</html>