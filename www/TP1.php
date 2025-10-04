<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire HTML-PHP</title>
    <link rel="stylesheet" href="style.css">
</head>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/var/www/vendor/autoload.php';

//Déclaration des variables
$firstname = $lastname = $email = $pwd = $pwdConfirm = "";
$pdo = new PDO('pgsql:host=db;port=5432;dbname=devdb', 'devuser', 'devpass');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Nettoyage des valeurs
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $email = strtolower(trim($_POST["email"]));
    $pwd = $_POST["pwd"];
    $pwdConfirm = $_POST["pwdConfirm"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide.";
    }

    if(empty($email)) {
        $errors[] = "L'email est obligatoire.";
    }

    if (strlen($pwd) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    if(empty($pwd) || empty($pwdConfirm)) {
        $errors[] = "Le mot de passe est obligatoire.";
    }

    if ($pwd !== $pwdConfirm) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    if(!preg_match('/[A-Z]/', $pwd)) {
        $errors[] = "Le mot de passe doit contenir au moins une lettre majuscule.";
    }

    if(!preg_match('/[a-z]/', $pwd)) {
        $errors[] = "Le mot de passe doit contenir au moins une lettre minuscule.";
    }

    if(!preg_match('/[0-9]/', $pwd)) {
        $errors[] = "Le mot de passe doit contenir au moins un chiffre.";
    }

// Unicité de l'email
    if (empty($errors)) {
        $req = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $req->execute([$email]);
        if ($req->fetch()) {
            $errors[] = "Cet email est déjà utilisé.";
        }
    }
    // Insertion en BDD
    if(empty($errors)) {
        $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT);
        $req= $pdo->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
        $req->execute([$firstname,$lastname, $email, $hashedPwd]);
    }

// Après l'insertion en BDD, ajoutez :
    if(empty($errors)) {
        // Générer un token de validation
        $token = bin2hex(random_bytes(32));

        // Mettre à jour l'utilisateur avec le token
        $req = $pdo->prepare("UPDATE users SET validation_token = ?, email_verified = FALSE WHERE email = ?");
        $req->execute([$token, $email]);

        // Envoyer l'email avec PHPMailer
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp-relay.brevo.com';
            $mail->SMTPAuth = true;
            $mail->Username = '9874d5001@smtp-brevo.com';
            $mail->Password = 'kOChRB6wFdW4IKrZ';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom('9874d5001@smtp-brevo.com', 'TP1');
            $mail->addAddress($email);
            $mail->Subject = 'Validez votre compte';

            $validationLink = "http://localhost/validate.php?token=" . $token;
            $mail->Body = "Cliquez ici pour valider votre compte : <a href='$validationLink'>$validationLink</a>";

            $mail->send();
            echo "<p class='success'>Email de validation envoyé !</p>";
        } catch (Exception $e) {
            echo "<p class='error'>Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}</p>";
        }
    }

    // Affichage des erreurs
    if(!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p class='error'>$error</p>";
        }
    } else {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            echo "<p class='success'>Inscription réussie !</p>";
            $firstname = $lastname = $email = "";
        }
    }
}
?>

<body>
<form action="" method="post">
    <label for="firstname">Prénom :</label>
    <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($firstname) ?>">

    <label for="lastname">Nom :</label>
    <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($lastname) ?>">

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

    <label for="pwd">Mot de passe :</label>
    <input type="password" id="pwd" name="pwd" required>

    <label for="pwdConfirm">Confirmer le mot de passe :</label>
    <input type="password" id="pwdConfirm" name="pwdConfirm" required>

    <input type="submit" value="Valider">
</form>
</html>
