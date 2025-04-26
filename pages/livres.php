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
    // Utilisation de $pdo au lieu de $recup qui n'existe pas
    $livre = $pdo->prepare("SELECT * FROM livres");
    $livre->execute();
    $affich = $livre->fetchAll(PDO::FETCH_ASSOC);

    // Boucle corrigée avec le contenu à l'intérieur
    foreach($affich as $affichage) {
    ?>
        <div class="card">
            <span class="blog-time"></span>
            <div class="description">
                <p>Nom du livre : <?php echo ($affichage["titre"]); ?></p>
                <p>Nom de l'auteur : <?php echo ($affichage["auteur"]); ?></p>
                <p>Le genre : <?php echo ($affichage["genre"]); ?></p>
                <p>Le statut : <?php echo ($affichage["statut"]); ?></p>
            </div>
        </div>
    <?php 
    } 
    ?>
</body>
</html>