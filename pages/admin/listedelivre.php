<?php
include '../../common/header.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}


$stmt = $pdo->prepare("SELECT * FROM livres");
$stmt->execute();
$livre = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

    <?php
    foreach ($livre as $livr) { ?>
        <p> Nom du livre : <?php echo $livr["titre"]; ?> </p>
        <p> Auteur : <?php echo $livr["auteur"]; ?> </p>
        <p> genre : <?php echo $livr["genre"]; ?> </p>
        <p> statut : <?php echo $livr["statut"]; ?> </p>

        <?php
    }
    ?>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.jade.min.css">
    <link rel="stylesheet" href="../../public/style.css">

</body>

</html>