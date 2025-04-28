<?php
include '../../common/header.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM utilisateurs");
$stmt->execute();
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM livres");
$stmt->execute();
$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<table border="1" cellpadding="10">
        <thead>
            <tr>
            <th>ID de l'utilisateur </th>
                <th>Nom de l'utilisateur</th>
                <th>Adresse mail de l'utilisateur</th>
                <th>Livre emprunté </th>
            </tr>
        </thead>
<?php

    foreach($utilisateurs as $utilisateur) { ?>
       <td><?= htmlspecialchars(string: $utilisateur['nom']) ?></td>
       <td><?= htmlspecialchars($utilisateur['email']) ?></td>
    <?php } ?>

    <?php
    foreach($livres as $livre) { ?>
         <td><?= htmlspecialchars($livre['id']) ?></td>
                   
                   <td><?= htmlspecialchars($livre['titre']) ?></td>
    <?php } ?>
    
   
    

</body>
</html>
