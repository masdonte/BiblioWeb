<?php
include '../../common/header.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// Fetch all users
$stmt = $pdo->prepare("SELECT * FROM utilisateurs");
$stmt->execute();
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all books and their associated users through emprunts
$sql = "SELECT emprunts.id_utilisateur, livres.id AS livre_id, livres.titre 
        FROM emprunts 
        JOIN livres ON emprunts.id_livre = livres.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

$livresParUtilisateur = [];
foreach ($livres as $livre) {
    $livresParUtilisateur[$livre['id_utilisateur']][] = $livre; 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs et Livres</title>
</head>

<body>
    <h1>Liste des Utilisateurs avec leurs livres</h1>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Livres</th>
        </tr>
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <?php if ($utilisateur['id'] !== 1): // Exclude user with ID 1 (admin) ?>
                <tr>
                    <td><?= htmlspecialchars($utilisateur['id']) ?></td>
                    <td><?= htmlspecialchars($utilisateur['nom']) ?></td>
                    <td><?= htmlspecialchars($utilisateur['email']) ?></td>
                    <td>
                        <ul>
                            <?php if (isset($livresParUtilisateur[$utilisateur['id']])): ?>
                                <?php foreach ($livresParUtilisateur[$utilisateur['id']] as $livre): ?>
                                    <li><?= htmlspecialchars($livre['titre']) ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>Aucun livre</li>
                            <?php endif; ?>
                        </ul>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
       
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.jade.min.css"
>
</body>
   


</html>