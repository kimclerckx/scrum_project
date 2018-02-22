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
    $adminCheck = !empty($_POST['adminCheck']) ? trim($_POST['adminCheck']) : null;

    //3. Check if fields are empty

    if (empty($email)) {
        $errors[] = "E-mailadres is verplicht";
    }
    if (empty($password)) {
        $errors[] = "Wachtwoord is verplicht";
    }
    if (empty($passwordConfirm)) {
        $errors[] = "Bevestig je wachtwoord";
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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="header">
    <a href="index.php">Adminpagina</a>
</div>

<?php if (!empty($message)) : ?>
    <p><?= $message ?></p>
<?php endif; ?>
<h1>Registreer een nieuwe gebruiker</h1>
<form action="newUser.php" method="post">
    <input type="text" placeholder="Voer een geldig e-mailadres in" name="email">
    <input type="password" placeholder="Kies een wachtwoord" name="password">
    <input type="password" placeholder="Herhaal het wachtwoord" name="passwordConfirm">
    <br/><br/>
    <input type="submit" name="register" value="Registreren">
</form>
<br/>
<a class="btn" href="index.php">Return Home</a>
<br/>
<!-- implode —> Join array elements with a string and use seperator <br><br> in this case (showing the different error messages under each other)-->
<p><?php echo implode("<br><br>", $errors); ?></p>
</body>
</html>