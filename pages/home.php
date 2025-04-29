<?php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");

    //Configuration de PDO pour permettre la bonne gestion des erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>


<?php if (isset($_POST['logout']) && $_POST['logout'] === 'success'): ?>
    <script>
        alert("Vous avez été déconnecté avec succès !");
    </script>
<?php endif; ?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

    <div class="home">
        <?php if (isset($_SESSION['user'])): ?>
            <h2>Bienvenue, <?= htmlspecialchars($_SESSION['user']['nom']); ?> !</h2>
            <p>Que souhaitez-vous faire aujourd'hui ?</p>

        <?php else: ?>
            <h2>Bienvenue sur la BiblioWeb !</h2>
            <p>Inscrivez-vous ou connectez-vous pour accéder à notre collection de livres. </p>
            <p>Votre destination ultime pour les amoureux de la lecture.
                Plongez dans l'univers de la lecture.
            </p>
            
            <img  class="image"src ="https://static.vecteezy.com/ti/photos-gratuite/t1/44280984-empiler-de-livres-sur-une-marron-contexte-concept-pour-monde-livre-journee-photo.jpg" alt="">
        <?php endif; ?>
       
    </div>
</body>

</html>