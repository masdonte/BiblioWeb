<?php

include 'common/header.php';
try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");

    //Configuration de PDO pour permettre la bonne gestion des erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}


// === 1. TRAITEMENT DE LA CONNEXION ===
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cas spécial pour l'administrateur
    if ($email === 'admin@biblio.com' && $password === 'admin123') {
        $_SESSION['user'] = [
            'email' => $email,
            'role' => 'admin'
        ];
        header('Location: ' . URL . 'pages/admin/listeutilisateur.php');
        exit();
    }

    // Vérifier si l'utilisateur existe
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier le mot de passe
    if ($user && hash('sha256', $password) === $user['mot_de_passe']) {
        $_SESSION['user'] = [
            'email' => $user['email'],
            'role' => $user['role'] // On ajoute le rôle récupéré depuis la base de données
        ];
        $_SESSION["connected"] = true;
        header("Location: index.php");  // Redirection après connexion
        exit();
    } else {
        echo "<script>alert('Identifiants incorrects !');</script>";
    }

}


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <!--=============== LOGIN ===============-->
    <div class="login container" id="loginAccessRegister">
        <!--===== LOGIN ACCESS =====-->
        <h1>Se connecter</h1>
        <form action="" method="POST" class="login__form">
            <div>
                <input type="email" name="email" id="email" required placeholder="E-mail" class="login__input">
                <label for="email">E-mail</label>
            </div>

            <div>
                <input type="password" name="password" id="password" required placeholder="Mot de passe"
                    class="login__input">
                <label for="password">Mot de passe</label>
                <i class="ri-eye-off-fill login__icon login__password" id="loginPassword"></i>
            </div>

            <button type="submit" class="login__button">Connexion</button>
        </form>

        <p>Pas de compte ? <a href="../Biblioweb/index.php?page=signon">Création de compte</a></p>
    </div>

</body>

</html>