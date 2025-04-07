<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}



// Requête SQL si une recherche a été effectuée
if (!empty($recherche)) {
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE titre ");
    $articles = $stmt;
} else {
    // Pour éviter les erreurs si aucune recherche n'est faite
    $articles = $pdo->query("SELECT * FROM livres LIMIT 0");
}

// Récupération de la route depuis l'URL
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

// Définition des pages autorisées
$pages = ['login', 'signon', 'livredetail', 'home'];

if ($page !== 'login') {
    include 'common/navbar.php';
}

// Vérification et inclusion de la bonne page
if (in_array($page, $pages)) {
    include 'pages/' . $page . '.php';
} else {
    include '404.php';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>
</head>
<body>

    <form method="GET">
        <input type="search" name="recherche" placeholder="Recherche..." />
        <input type="submit" value="Valider" />
    </form>
   
   

</body>
</html>
