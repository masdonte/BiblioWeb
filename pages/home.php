<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Bienvenue sur Biblioweb.</h1>
    <h2>Le lieu où trouver vos livres.</h2>

    <?php
    session_start();
    if (!isset($_SESSION['connected']) || !$_SESSION['connected']) {
        echo '<h2>Vous ne savez pas par où commencer ?</h2>';
    }
    ?>
    ;

</body>

</html>