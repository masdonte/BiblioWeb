<?php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");

    //Configuration de PDO pour permettre la bonne gestion des erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>


<?php if (isset($_GET['logout']) && $_GET['logout'] === 'success'): ?>
    <script>
        alert("Vous avez été déconnecté avec succès !");
    </script>
<?php endif; ?>

<?php if (isset($_SESSION['user'])): ?>
    <h2>Bienvenue, <?= htmlspecialchars($_SESSION['user']['nom']); ?> !</h2>
    <p>Que souhaitez-vous faire aujourd'hui ?</p>

<?php else: ?>
    <h2>Bienvenue sur la Bibliothèque en ligne !</h2>
    <p>Inscrivez-vous ou connectez-vous pour accéder à notre collection de livres.</p>

<?php endif; ?>