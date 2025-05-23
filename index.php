<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}


// Récupération de la route depuis l'URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Définition des pages autorisées
$pages = ['login', 'signon', 'livredetail', 'home', 'livres', 'logout', 'emprunt', 'livre_statut'];

if ($page !== 'login' && $page !== 'signon') {
    include 'common/header.php';
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
<html data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.jade.min.css">
</head>

<body>


</body>

</html>