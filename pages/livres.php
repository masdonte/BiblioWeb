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
    <form action="" method="post">
        <input type="search" name="barre" placeholder="Rechercher par titre ou auteur">
        <input type="submit" name="recherche" value="Rechercher">
    </form>

    <?php
    if (isset($_POST["recherche"]) && $_POST["recherche"] == "Rechercher") {
        $barre = htmlspecialchars($_POST["barre"]); // pour sécuriser le formulaire contre les failles HTML https://www.243tech.com/creer-une-barre-de-recherche-sur-son-site-php-mysql/
        $barre = trim($barre); // pour supprimer les espaces dans la requête de l'internaute
        $barre = strip_tags($barre); // pour supprimer les balises HTML 
    
        if (!empty($barre)) {
            $barre = '%' . strtolower(string: $barre) . '%';
            $livre = $pdo->prepare("SELECT * FROM livres WHERE LOWER(titre) LIKE :barre OR LOWER(auteur) LIKE :barre");
            $livre->bindParam(':barre', $barre, PDO::PARAM_STR);
            $livre->execute();
            $affich = $livre->fetchAll(PDO::FETCH_ASSOC);

            if (count($affich) > 0) {
                foreach ($affich as $affichage) {
                    ?>
                    <div class="card">
                        <span class="blog-time"></span>
                        <div class="description">
                            <p>Nom du livre : <?php echo htmlspecialchars($affichage["titre"]); ?></p>
                            <p>Nom de l'auteur : <?php echo htmlspecialchars($affichage["auteur"]); ?></p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "Aucun livre trouvé.";
            }
        } else {
            echo "Vous devez entrer votre requête dans la barre de recherche.";
        }
    } else {
        $livre = $pdo->prepare("SELECT * FROM livres");
        $livre->execute();
        $affich = $livre->fetchAll(PDO::FETCH_ASSOC);

        foreach ($affich as $affichage) {
            ?>
            <div class="card">
                <span class="blog-time"></span>
                <div class="description">
                    <p>Nom du livre : <?php echo htmlspecialchars($affichage["titre"]); ?></p>
                    <p>Nom de l'auteur : <?php echo htmlspecialchars($affichage["auteur"]); ?></p>
                    <p>Le genre : <?php echo htmlspecialchars($affichage["genre"]); ?></p>
                    <p>Le statut : <?php echo htmlspecialchars($affichage["statut"]); ?></p>
                </div>
            </div>
            <?php
        }
    }
    ?>
</body>

</html>