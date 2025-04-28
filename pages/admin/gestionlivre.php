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

// 1) == Traitement de la suppression ==
if (isset($_POST['supprimer_id'])) {
    $id = $_POST['supprimer_id'];

    $stmt = $pdo->prepare("DELETE FROM livres WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Erreur lors de la suppression du livre.";
    }
}

// 2) == Traitement de la modification ==
if (isset($_POST['modifier_id'])) {
    $id = $_POST['modifier_id'];
    $titre = $_POST['titre'];
    $statut = $_POST['statut'];
    $auteur = $_POST['auteur']; 
    $genre = $_POST['genre']; 

    $stmt = $pdo->prepare("UPDATE livres SET titre = :titre, statut = :statut, auteur = :auteur, genre = :genre WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
    $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
    $stmt->bindParam(':auteur', $auteur, PDO::PARAM_STR); // Nouveau champ
    $stmt->bindParam(':genre', $genre, PDO::PARAM_STR); // Nouveau champ

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Erreur lors de la modification du livre.";
    }
}

// 3) == Traitement de l'ajout ==
if (isset($_POST['ajouter_livre'])) {
    $titre = $_POST['titre'];
    $statut = $_POST['statut'];
    $auteur = $_POST['auteur']; // Nouveau champ
    $genre = $_POST['genre']; // Nouveau champ

    $stmt = $pdo->prepare("INSERT INTO livres (titre, statut, auteur, genre) VALUES (:titre, :statut, :auteur, :genre)");
    $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
    $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
    $stmt->bindParam(':auteur', $auteur, PDO::PARAM_STR); // Nouveau champ
    $stmt->bindParam(':genre', $genre, PDO::PARAM_STR); // Nouveau champ

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Erreur lors de l'ajout du livre.";
    }
}

// 4) == Affichage du formulaire de modification ==
$modifier_id = isset($_GET['modifier_id']) ? $_GET['modifier_id'] : null;
$livre_a_modifier = null;

if ($modifier_id) {
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE id = :id");
    $stmt->bindParam(':id', $modifier_id, PDO::PARAM_INT);
    $stmt->execute();
    $livre_a_modifier = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Vérification si le formulaire d'ajout doit être affiché
$afficher_formulaire_ajout = isset($_POST['afficher_formulaire_ajout']);

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
            <th>Auteur</th> <!-- Nouveau champ -->
            <th>Genre</th> <!-- Nouveau champ -->
            <th>Actions</th>
        </tr>
        <?php foreach ($livres as $livre): ?>
            <tr>
                <td><?= htmlspecialchars($livre['id']) ?></td>
                <td><?= htmlspecialchars($livre['titre']) ?></td>
                <td><?= htmlspecialchars($livre['statut']) ?></td>
                <td><?= htmlspecialchars($livre['auteur']) ?></td> <!-- Nouveau champ -->
                <td><?= htmlspecialchars($livre['genre']) ?></td> <!-- Nouveau champ -->
                <td>
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="supprimer_id" value="<?= htmlspecialchars($livre['id']) ?>">
                        <input type="submit" value="Supprimer">
                    </form>
                    <form action="" method="get" style="display:inline;">
                        <input type="hidden" name="modifier_id" value="<?= htmlspecialchars($livre['id']) ?>">
                        <input type="submit" value="Modifier">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if ($livre_a_modifier): ?>
        <h2>Modifier le livre</h2>
        <form action="" method="post">
            <input type="hidden" name="modifier_id" value="<?= htmlspecialchars($livre_a_modifier['id']) ?>">
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($livre_a_modifier['titre']) ?>" required><br>
            <label for="statut">Statut :</label>
            <input type="text" id="statut" name="statut" value="<?= htmlspecialchars($livre_a_modifier['statut']) ?>" required><br>
            <label for="auteur">Auteur :</label> <!-- Nouveau champ -->
            <input type="text" id="auteur" name="auteur" value="<?= htmlspecialchars($livre_a_modifier['auteur']) ?>" required><br>
            <label for="genre">Genre :</label> <!-- Nouveau champ -->
            <input type="text" id="genre" name="genre" value="<?= htmlspecialchars($livre_a_modifier['genre']) ?>" required><br>
            <input type="submit" value="Enregistrer">
        </form>
    <?php endif; ?>

    <?php if ($afficher_formulaire_ajout): ?>
        <h2>Ajouter un livre</h2>
        <form action="" method="post">
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" required><br>
            <label for="statut">Statut :</label>
            <input type="text" id="statut" name="statut" required><br>
            <label for="auteur">Auteur :</label> <!-- Nouveau champ -->
            <input type="text" id="auteur" name="auteur" required><br>
            <label for="genre">Genre :</label> <!-- Nouveau champ -->
            <input type="text" id="genre" name="genre" required><br>
            <input type="submit" name="ajouter_livre" value="Ajouter">
        </form>
    <?php else: ?>
        <form action="" method="post">
            <input type="hidden" name="afficher_formulaire_ajout" value="1">
            <input type="submit" value="Ajouter un livre">
        </form>
    <?php endif; ?>
</body>

</html>
