<?php
include '../../common/header.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}


$stmt = $pdo->prepare("SELECT * FROM utilisateurs");
$stmt->execute();
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html lang="fr">
<html data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


    <?php
    foreach ($utilisateurs as $utilisateur): ?>
        <div class="card">

            <p> Nom de l'utilisateur : <?php echo $utilisateur["nom"]; ?> </p>
            <p> Adresse mail de l'utilisateur : <?php echo $utilisateur["email"]; ?> </p>
        </div>
        <?php
    endforeach; ?>
    </div>



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.jade.min.css">
    <link rel="stylesheet" href="../../public/style.css">
</body>

</html>