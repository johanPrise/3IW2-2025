<?php
require_once '/var/www/vendor/autoload.php';


if (!isset($_GET['id']) || !isset($_GET['email']) || !isset($_GET['firstname']) || !isset($_GET['lastname'])) {
    header('Location: TP2.php');
    exit;
}

$id = (int)$_GET['id'];
$email = $_GET['email'];
$firstname = $_GET['firstname'];
$lastname = $_GET['lastname'];

try {
    $pdo = new PDO('pgsql:host=db;port=5432;dbname=devdb', 'devuser', 'devpass');
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Suppression de l'utilisateur
$sql = 'DELETE FROM "users" WHERE id = :id';
$queryPrepared = $pdo->prepare($sql);
$result = $queryPrepared->execute(['id' => $id]);


// Redirection vers la liste avec message
header('Location: TP2.php');
exit;
