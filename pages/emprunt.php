<?php



try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

$userId = $_SESSION['user']['id'];

// === 1. TRAITEMENT DU RETOUR D'UN LIVRE ===
if (isset($_POST['rendre_id'])) {
    $empruntId = $_POST['rendre_id'];

    // Vérifier que l'emprunt appartient bien à l'utilisateur connecté
    $stmt = $pdo->prepare("SELECT * FROM emprunts WHERE id = :id AND id_utilisateur = :userId");
    $stmt->bindParam(':id', $empruntId, PDO::PARAM_INT);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $emprunt = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($emprunt && !$emprunt['date_retour']) {
        // 1. Mettre à jour la date_retour
        $updateStmt = $pdo->prepare("UPDATE emprunts SET date_retour = NOW() WHERE id = :id");
        $updateStmt->bindParam(':id', $empruntId, PDO::PARAM_INT);
        $updateStmt->execute();

        // 2. Remettre le livre en statut 'disponible'
        $updateLivre = $pdo->prepare("UPDATE livres SET statut = 'disponible' WHERE id = :livreId");
        $updateLivre->bindParam(':livreId', $emprunt['id_livre'], PDO::PARAM_INT);
        $updateLivre->execute();
    }
}

// === 2. RÉCUPÉRER LES EMPRUNTS DE L'UTILISATEUR ===
$sql = "SELECT emprunts.id, emprunts.id_livre, livres.titre, livres.auteur, emprunts.date_emprunt, emprunts.date_retour
        FROM emprunts
        JOIN livres ON emprunts.id_livre = livres.id
        WHERE emprunts.id_utilisateur = :userId
        ORDER BY emprunts.date_emprunt DESC";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();
$emprunts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mes Emprunts</title>
</head>

<body>
    <h1>Mes Emprunts</h1>

    <?php if (empty($emprunts)): ?>
        <p>Vous n'avez aucun emprunt en cours.</p>
    <?php else: ?>
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Titre du livre</th>
                    <th>Auteur</th>
                    <th>Date d'emprunt</th>
                    <th>Date de retour</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emprunts as $emprunt): ?>
                    <tr>
                        <td><?= htmlspecialchars($emprunt['titre']) ?></td>
                        <td><?= htmlspecialchars($emprunt['auteur']) ?></td>
                        <td><?= htmlspecialchars($emprunt['date_emprunt']) ?></td>
                        <td>
                            <?= $emprunt['date_retour'] ? htmlspecialchars($emprunt['date_retour']) : 'Pas encore rendu' ?>
                        </td>
                        <td>
                            <?php if (!$emprunt['date_retour']): ?>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="rendre_id" value="<?= $emprunt['id'] ?>">
                                    <button type="submit">Rendre</button>
                                </form>
                            <?php else: ?>
                                Déjà rendu
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>

</html>