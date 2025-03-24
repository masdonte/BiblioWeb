<?php
// Récupération de la route depuis l'URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Définition des pages autorisées
$pages = ['login'];

include 'common/navbar.php';

// Vérification et inclusion de la bonne page
if (in_array($page, $pages)) {
    include 'pages/' . $page . '.php';
} else {
    include '404.php';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body>

</body>

</html>