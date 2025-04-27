<?php
include '../../common/header.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération des livres
$stmt = $pdo->prepare("SELECT * FROM livres");
$stmt->execute();
$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);




// Suppression d'un livre
$stmt = $pdo->prepare("DELETE FROM livres WHERE titre = :titre AND auteur = :auteur AND genre = :genre AND statut = :statut");

$stmt->bindParam(':titre', $titre);
$stmt->bindParam(':auteur', $auteur);
$stmt->bindParam(':genre', $genre);
$stmt->bindParam(':statut', $statut);

$stmt->execute();

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
    foreach($livres as $livre) {?>
    <p> Le titre du livre : <?php echo $livre ["titre"]; ?> </p>
    <p> L'auteur du livre : <?php echo $livre ["auteur"]; ?> </p>
    <p> Le genre : <?php echo $livre ["genre"]; ?> </p>
    <p> Statut: <?php echo $livre ["statut"]; ?> </p>
    
    
    <?php
    }
    ?>

    <button >Supprimer le livre</button>
    <button>Modifier le livre</button>
</body>
</html>