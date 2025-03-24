<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblioweb", "root", "");

    //Configuration de PDO pour permettre la bonne gestion des erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie";
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>