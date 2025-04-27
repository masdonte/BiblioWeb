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
$pages = ['login', 'signon', 'livredetail', 'home', 'livres', 'logout'];

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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>
</head>

<body>


</body>

</html>