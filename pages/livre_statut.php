<?php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}


// === 1. EMPRUNT DE LIVRE ===
if (isset($_POST['emprunter']) && isset($_POST['livre_id'])) {
    $livre_id = $_POST['livre_id'];

    $id_utilisateur = $_SESSION['user']['id']; // ID du user connecté

    // Vérifier si le livre est toujours disponible
    $checkLivre = $pdo->prepare("SELECT statut FROM livres WHERE id = :id_livre");
    $checkLivre->bindParam(':id_livre', $livre_id, PDO::PARAM_INT);
    $checkLivre->execute();
    $livre = $checkLivre->fetch(PDO::FETCH_ASSOC);

    if ($livre && $livre['statut'] === 'disponible') {
        // Insérer l'emprunt
        $stmt = $pdo->prepare("INSERT INTO emprunts (id_utilisateur, id_livre) VALUES (:id_utilisateur, :id_livre)");
        $stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':id_livre', $livre_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Mettre à jour le statut du livre
            $updateLivre = $pdo->prepare("UPDATE livres SET statut = 'emprunté' WHERE id = :id_livre");
            $updateLivre->bindParam(':id_livre', $livre_id, PDO::PARAM_INT);
            $updateLivre->execute();

            echo "<script>alert('livre emprunté  ');</script>";
            exit;
        } else {
            echo "<script>alert('Erreur lors de l\'emprunt du livre.');</script>";
        }
    } else {
        echo "<script>alert('Le livre n\'est plus disponible.');</script>";
    }
}

// === 2. AFFICHAGE DES LIVRES ===
$livre = $pdo->prepare("SELECT * FROM livres");
$livre->execute();
$affich = $livre->fetchAll(PDO::FETCH_ASSOC);
?>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des livres</title>
</head>

<body>

    <h1>Liste des livres disponibles</h1>

    <?php foreach ($affich as $affichage) { ?>
        <div class="card" style="border:1px solid #ccc; padding:10px; margin:10px;">
            <div class="description">
                <p>Nom du livre : <?php echo ($affichage["titre"]); ?></p>
                <p>Le statut : <?php echo ($affichage["statut"]); ?></p>


                <form action="" method="POST">
                    <input type="hidden" name="livre_id" value="<?= $affichage['id']; ?>">
                    <button type="submit" name="emprunter">Emprunter ce livre</button>
                </form>
            </div>
        </div>
    <?php } ?>

</body>

</html>