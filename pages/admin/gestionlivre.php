<?php

include '../../common/header.php';



try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}




// Vérifier que l'emprunt appartient bien à l'utilisateur connecté
$stmt = $pdo->prepare("SELECT * FROM livres");
$stmt->execute();
$livres = $stmt->fetch(PDO::FETCH_ASSOC);




?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

</head>

<body>
    <h1>Gestion des livres</h1>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Titre du livre</th>
                <th>Auteur</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($livres as $livre): ?>
                <tr>
                    <td><?= htmlspecialchars(string: $livres['titre']) ?></td>
                    <td><?= htmlspecialchars($livres['auteur']) ?></td>
                    <td><?= htmlspecialchars($livres['statut']) ?></td>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>