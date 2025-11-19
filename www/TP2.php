<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau HTML-PHP</title>
    <link rel="stylesheet" href="style.css">
</head>

<?php

/*
 * Un tableau HTML avec la liste des users
 * et un bouton par ligne pour supprimer un user
 * avec un confirm JS pour confirmer la suppression en BDD
 * et un mail pour prévenir le user
 */

?>

<body>
    <h1>Liste des utilisateurs</h1>

    <?php
    if (isset($_GET['message'])) {
        echo '<div class="message">' . htmlspecialchars($_GET['message']) . '</div>';
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $pdo = new PDO('pgsql:host=db;port=5432;dbname=devdb', 'devuser', 'devpass');
            } catch (Exception $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }

            // Récupération des utilisateurs depuis la BDD
            $sql = 'SELECT id, firstname, lastname, email, email_verified FROM "users" ORDER BY id';
            $query = $pdo->query($sql);
            $users = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $user) {
                echo '<tr>';
                echo '<td>' . ($user['id']) . '</td>';
                echo '<td>' . ($user['lastname']) . '</td>';
                echo '<td>' . ($user['firstname']) . '</td>';
                echo '<td>' . ($user['email']) . '</td>';
                echo '<td>' . ($user['email_verified'] ? 'Actif' : 'Inactif') . '</td>';
                echo '<td><button onclick="confirmDelete(' . $user['id'] . ", '" . ($user['email']) . "', '" . ($user['firstname']) . "', '" . ($user['lastname']) . '\')">Supprimer</button></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <script>
        function confirmDelete(userId, userEmail, firstname, lastname) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                window.location.href = 'delete_user.php?id=' + userId + '&email=' + encodeURIComponent(userEmail) + '&firstname=' + encodeURIComponent(firstname) + '&lastname=' + encodeURIComponent(lastname);
            }
        }
    </script>
</body>

</html>