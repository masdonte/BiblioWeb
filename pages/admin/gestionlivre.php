<?php
include '../../common/header.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$stmt = $pdo->prepare("SELECT id, titre, auteur, genre, statut FROM livres");
$stmt->execute();
$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    foreach ($livres as $livre): ?>
        <p> Le titre du livre : <?php echo $livre["titre"]; ?> </p>
        <p> Statut: <?php echo $livre["statut"]; ?> </p>
        <form action="" method="POST">
            <input type="hidden" name="livre_id" value="<?= $livre['id']; ?>">
            <button type="submit" name="delete">Supprimer</button>

        </form>

    <?php endforeach; ?>

    <?php
    if (isset($_POST['delete']) && isset($_POST['livre_id'])) {
        $livre_id = $_POST['livre_id'];

        $stmt = $pdo->prepare("DELETE FROM livres WHERE id = :id");
        $stmt->bindParam(':id', $livre_id);
        if ($stmt->execute()) {
            echo "<script>alert('livre supprimé');</script>";
        } else {
            echo "<script>alert('erreur lors de la supression du livre');</script>";
        }
    }


    ?>
</body>

</html>