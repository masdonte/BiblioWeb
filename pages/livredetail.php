<?php
// include("../include/permission.php");
include('common/config.php'); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>

</head>

<body>
    <main>
        <?php
        // Récupérer toutes les livres d'entreprises
        $stmt = $pdo->prepare("SELECT * FROM livres");
        $stmt->execute();
        $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Boucle à travers chaque livre et générer une carte
        foreach ($livres as $livre) {
            ?>
            <p>Titre : <?php echo $livre["titre"]; ?> </p>
            <p>Auteur : <?php echo $livre["auteur"]; ?></p>

            <p>Genre : <?php echo $livre["genre"]; ?></p>

            <p>Statut : <?php echo $livre["statut"]; ?></p>


            <?php
        }
        ?>
    </main>

</body>

</html>