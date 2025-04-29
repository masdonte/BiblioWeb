<?php
if (!isset($_SESSION)) {
    session_start();
    define('URL', 'http://localhost/BiblioWeb/'); // https://www.php.net/manual/en/function.define.php
}
?>

<header>
    <h1 class="header">Bibliothèque en ligne</h1>
    <nav>
        <link rel="stylesheet" href="./public/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
        
    <div class="container">
        <a href="<?= URL ?>index.php?page=home">Accueil</a> |
        <?php if (!isset($_SESSION['user'])): ?>
            <a href="<?= URL ?>index.php?page=signon">Inscription</a> |
            <a href="<?= URL ?>index.php?page=login">Connexion</a> |
        <?php else: ?>
            <?php if ($_SESSION['user']['role'] !== 'admin'): ?>
                <a href="<?= URL ?>index.php?page=livres">Détails des livres</a> |
                <a href="<?= URL ?>index.php?page=emprunt">Mes Emprunts</a> |
                <a href="<?= URL ?>index.php?page=livre_statut">Statut des livres</a> |
            <?php endif; ?>
            <a href="<?= URL ?>index.php?page=logout">Déconnexion</a> |
            <?php if ($_SESSION['user']['role'] !== 'admin'): ?>
                <a>Vous êtes <?= htmlspecialchars($_SESSION['user']['nom']); ?> !</a>
            <?php elseif ($_SESSION['user']['role'] == 'admin'): ?>
                

                <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                    <a href="<?= URL ?>pages/admin/listeutilisateur.php">Listes Utilisateurs</a> |
                    <a href="<?= URL ?>pages/admin/detailutilisateur.php">Détails d'utilisateurs</a> |
                    <a href="<?= URL ?>pages/admin/gestionlivre.php">Gestion des livres</a> |
                    <a href="<?= URL ?>pages/admin/listedelivre.php">Listes de livres</a> |
                    <a>Vous êtes Admin !</a>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

    </nav>
    </div>
</header>