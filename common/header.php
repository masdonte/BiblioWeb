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
            <a href="<?= URL ?>index.php?page=livres">Livres</a> |
            <a href="<?= URL ?>index.php?page=emprunt">Mes Emprunts</a> |
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'): ?>
                <a href="<?= URL ?>pages/admin/admin_dashboard.php">Admin</a> |
            <?php endif; ?>
            <a href="<?= URL ?>index.php?page=logout">Déconnexion</a> |
        <?php endif; ?>
    </nav>
</header>