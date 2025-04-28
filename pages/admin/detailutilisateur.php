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
    
<?php
    foreach($utilisateurs as $utilisateur) { ?>
        <p>Nom de l'utilisateur : <?php echo htmlspecialchars($utilisateur["nom"]); ?></p>
        <p>Adresse mail de l'utilisateur : <?php echo htmlspecialchars($utilisateur["email"]); ?></p>
    <?php } ?>

    <?php
    foreach($livres as $livre) { ?>
        <p>Livre emprunté : <?php echo htmlspecialchars($livre["titre"]); ?></p>
        <p>ID : <?php echo htmlspecialchars($livre["id"]); ?></p>
    <?php } ?>
    
</body>
</html>
