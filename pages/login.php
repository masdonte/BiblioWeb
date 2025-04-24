<?php
session_start();
try {
    $pdo = new PDO("mysql:host=localhost;dbname=bdd", "root", "");

    //Configuration de PDO pour permettre la bonne gestion des erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// === 1. TRAITEMENT DE LA CONNEXION ===
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier si l'utilisateur existe
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier le mot de passe
    if ($user && hash('sha256', $password) === $user['mot_de_passe']) {
        $_SESSION['user_id'] = $user['email'];  // Utilisation de l'email comme identifiant de session
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
    <div class="login container grid" id="loginAccessRegister">
        <!--===== LOGIN ACCESS =====-->
        <div class="login__access">
            <h1 class="login__title">Se connecter</h1>
            <div class="login__area">
                <form action="" method="POST" class="login__form">
                    <div class="login__content grid">
                        <div class="login__box">
                            <input type="email" name="email" id="email" required placeholder=" " class="login__input">
                            <label for="email" class="login__label">E-mail</label>
                            <i class="ri-mail-fill login__icon"></i>
                        </div>

                        <div class="login__box">
                            <input type="password" name="password" id="password" required placeholder=" "
                                class="login__input">
                            <label for="password" class="login__label">Mot de passe</label>
                            <i class="ri-eye-off-fill login__icon login__password" id="loginPassword"></i>
                        </div>
                    </div>
                    <button type="submit" class="login__button">Connexion</button>
                </form>

                Pas de compte ?
                <button><a href="../Biblioweb/index.php?page=signon">Création de compte</a></button>
            </div>
        </div>

</body>

</html>