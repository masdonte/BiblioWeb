<?php
session_start();
# https://code.whatever.social/questions/10541439/header-location-relative-path-compatibility#20097052



define('URL', 'http://localhost/BiblioWeb/');

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['connected']) || !$_SESSION['connected']) {
    echo "<script>alert('Connectez-vous !');</script>";
    header(header: 'Location: ' .URL. 'index.php?pages=login.php');
    exit();
}

if ($_SESSION['is_admin'] = false;) {
    echo "<script>alert('Vous n'y avez pas accès');</script>";
    header('Location: ' .URL. 'index.php?pages=home.php');

    exit();
}

?>
