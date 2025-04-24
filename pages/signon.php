<?php
session_start();
try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// === TRAITEMENT DE L'INSCRIPTION ===
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = htmlspecialchars($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash sécurisé moderne

    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Cet email est déjà utilisé.');</script>";
    } else {
        // Insérer l'utilisateur
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, mot_de_passe) VALUES (:email, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            echo "<script>alert('Compte créé avec succès !');</script>";
            header("Location: login.php"); // Redirection après inscription
            exit();
        } else {
            echo "<script>alert('Erreur lors de l\'inscription.');</script>";
        }
    }
}




?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>
    <!--===== FORMULAIRE INSCRIPTION =====-->
    <form action="" method="POST" class="login__form">
        <h1>Créer un compte</h1>

        <input type="email" name="email" required>
        <label for="emailCreate" class="login__label">Email</label>
        <br>

        <input type="password" name="password" required placeholder=" " class="login__input">
        <label for="passwordCreate" class="login__label">Mot de passe</label>
        <br>

        <button type="submit" class="login__button">Créer un compte</button>
    </form>

    <p>Déjà un compte ?</p>

    <button><a href="../Biblioweb/index.php?page=login">Se connecter</a></button>
    </form>
</body>

</html>