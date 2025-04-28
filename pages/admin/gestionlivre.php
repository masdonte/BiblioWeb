<?php
include '../../common/header.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM livres");
$stmt->execute();
$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs et Livres</title>
</head>

<body>
    <h1>Gestion des livres</h1>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nom</th>
             <th>Statut</th>
   
        </tr>
        <?php foreach ($livres as $livre): ?>
            <tr>
                <td><?= htmlspecialchars($livre['id']) ?></td>
                <td><?= htmlspecialchars($livre['titre']) ?></td>
                <td><?= htmlspecialchars($livre['statut']) ?></td>
                <?php endforeach; ?>
            </td>
        </tr>
    </table>
</body>
