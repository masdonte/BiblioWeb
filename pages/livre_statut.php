<?php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des livres</title>
</head>

<body>
    <?php

    $livre = $pdo->prepare("SELECT * FROM livres");
    $livre->execute();
    $affich = $livre->fetchAll(PDO::FETCH_ASSOC);


    foreach ($affich as $affichage) {
        ?>
        <div class="card">
            <span class="blog-time"></span>
            <div class="description">
                <p>Nom du livre : <?php echo ($affichage["titre"]); ?></p>
                <p>Le statut : <?php echo ($affichage["statut"]); ?></p>


                <form action="" method="POST">
                    <input type="hidden" name="livre_id" value="<?= $affichage['id']; ?>">
                    <button type="submit" name="emprunter">Emprunter ce livre</button>
                </form>
            </div>
        </div>
        <?php
    }

    if (isset($_POST['emprunter']) && isset($_POST['livre_id'])) {
        $livre_id = $_POST['livre_id'];



        $id_utilisateur = $_SESSION['id'];

        $stmt = $pdo->prepare("INSERT INTO emprunts (id_utilisateur, id_livre) VALUES (:id_utilisateur, :id_livre)");
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        $stmt->bindParam(':id_livre', $livre_id);


        if ($stmt->execute()) {
            echo "<script>alert('Livre emprunté avec succès !');</script>";
        } else {
            echo "<script>alert('Erreur lors de l\'emprunt du livre.');</script>";
        }
    }
    ?>
</body>

</html>