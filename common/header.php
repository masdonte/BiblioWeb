<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<header>
    <h1>Bibliothèque en ligne</h1>
    <nav>
        <a href="../BiblioWeb/index.php?page=home">Accueil</a> |
        <?php if (!isset($_SESSION['user'])): ?>
            <a href="../BiblioWeb/index.php?page=signon">Inscription</a> |
            <a href="../BiblioWeb/index.php?page=login">Connexion</a>

        <?php else: ?>
            <a href="pages/livres.php">Livres</a> |
            <a href="pages/emprunts.php">Mes Emprunts</a> |
            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                <a href="/BiblioWeb/pages/admin/admin_dashboard.php">Admin</a> |
            <?php endif; ?>
            <a href="/BiblioWeb/index.php?page=logout">Déconnexion</a>
        <?php endif; ?>
    </nav>
</header>
