<?php
if (!isset($_SESSION)) {
    session_start();
    define('URL', 'http://localhost/BiblioWeb/'); // https://www.php.net/manual/en/function.define.php
}
?>
<header>
    <h1>Bibliothèque en ligne</h1>
    <nav>
        <a href="<?= URL ?>index.php?page=home">Accueil</a> |
        <?php if (!isset($_SESSION['user'])): ?>
            <a href="<?= URL ?>index.php?page=signon">Inscription</a> |
            <a href="<?= URL ?>index.php?page=login">Connexion</a> |
        <?php else: ?>
            <?php if ($_SESSION['user']['role'] !== 'admin'): ?>
                <a href="<?= URL ?>index.php?page=livres">Détails des livres</a> |
                <a href="<?= URL ?>index.php?page=emprunt">Mes Emprunts</a> |
                <a href="<?= URL ?>index.php?page=livres_status">Livres status</a> |
            <?php endif; ?>
            <a href="<?= URL ?>index.php?page=logout">Déconnexion</a> |
            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                <a href="<?= URL ?>pages/admin/listes_utilisateurs.php">Listes Utilisateurs</a> |
                <a href="<?= URL ?>pages/admin/detail_utilisateurs.php">Détails d'utilisateurs</a> |
                <a href="<?= URL ?>pages/admin/gestionlivre.php">Gestion des livres</a> |
                <a href="<?= URL ?>pages/admin/listes_livres.php">Listes de livres</a> |
            <?php endif; ?>
        <?php endif; ?>
    </nav>
</header>