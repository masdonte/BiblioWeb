<?php
include 'common/header.php';
try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");

    // Configuration de PDO pour permettre la bonne gestion des erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// === 1. TRAITEMENT DE LA CONNEXION ===
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier si l'utilisateur existe en base de données
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe et si le mot de passe est correct
    if ($user && password_verify($password, $user['mot_de_passe'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'nom' => $user['nom'], 
            'email' => $user['email'],
            'role' => $user['role']
        ];
        $_SESSION["connected"] = true;

        if ($_SESSION['user']['role'] === 'admin') {
            header('Location: ' . URL . 'pages/admin/gestionlivre.php');
        } else {
            header("Location: " . URL . "index.php?page=home");
        }
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

       
        <form action="" method="POST" class="login">
        <h1>Se connecter</h1>
            <div>
                <input type="email" name="email" id="email" required placeholder="E-mail" class="login__input">
                <label for="email"></label>
            </div>

            <div>
                <input type="password" name="password" id="password" required placeholder="Mot de passe"
                    class="login__input">
                <label for="password">Mot de passe</label>
                <i class="ri-eye-off-fill login__icon login__password" id="loginPassword"></i>
            </div>

            <button type="submit" class="login__button">Connexion</button>
            <p>Pas de compte ? <a href="../Biblioweb/index.php?page=signon">Création de compte</a></p>
        </form>

       
    </div>
</body>

</html>