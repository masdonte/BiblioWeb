<?php
session_start();
try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");

    //Configuration de PDO pour permettre la bonne gestion des erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// === 2. TRAITEMENT DE L'INSCRIPTION ===
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = htmlspecialchars($_POST["email"]);
    $password = hash("sha256", $_POST["password"]); // Hashage sécurisé

    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "
<script>alert('Cet email est déjà utilisé.');</script>";
    } else {
        // Insérer l'utilisateurs
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, mot_de_passe) VALUES (:email,
:password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            echo "
<script>alert('Compte créé avec succès !');</script>";

            header("Location: login.php"); // Redirection vers connexion
            exit();
        } else {
            echo "
<script>alert('Erreur lors de l\'inscription.');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!--===== LOGIN REGISTER =====-->
    <form action="" method="POST" class="login__form"></form>
    <h1 class="">Créer un compte</h1>


    <input type="email" name="email">
    <label for="emailCreate" class="login__label">Email</label>
<br>
    <input type="password" name="password" required placeholder=" " class="login__input">
    <label for="passwordCreate" class="login__label">Mot de Passe</label>
<br>
    <button type="submit" class="login__button">Créer un compte</button>
<br>
    <p>Déjà un compte ? </p>
    <button id="loginButtonAccess">Se connecter</button>
</body>

</html>