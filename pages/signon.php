<?php
include 'common/header.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["nom"])) {
    $nom = htmlspecialchars($_POST["nom"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Cet email est déjà utilisé.');</script>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES (:nom, :email, :password, 'standard')");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            $stmt = $pdo->prepare("SELECT id, nom, email, role FROM utilisateurs WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['user'] = [
                'id' => $user['id'],
                'nom' => $user['nom'],
                'email' => $user['email'],
                'role' => $user['role']
            ];

            header("Location:/BiblioWeb/index.php?page=home");
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

    <main class="container-fluid">
        <div class="login">
            <form action="" method="POST" class="login__form">
                <h1>Créer un compte</h1>

                <input type="text" name="nom" required placeholder="Votre nom" class="login__input">
                <label for="nomCreate" class="login__label"></label>

                <input type="email" name="email" required placeholder="Votre email" class="login__input">
                <label for="emailCreate" class="login__label"></label>

                <input type="password" name="password" required placeholder="Votre mot de passe" class="login__input">
                <label for="passwordCreate" class="login__label"></label>

                <button type="submit" class="login__button">Créer un compte</button>
            </form>

            <p>Déjà un compte ?</p>
            <button class="secondary"><a href="../Biblioweb/index.php?page=login">Se connecter</a></button>
        </div>
        </div>
</body>

</html>