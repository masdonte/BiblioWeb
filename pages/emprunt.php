<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblio_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM emprunts ");
$stmt->execute();
$emprunts = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($emprunts as $livre) {
    ?>
    <div class="card">
        <h3 class="blog-title">
            <?php echo $livre["id_livre"]; ?>
        </h3>
        <span class="blog-time"></span>
        <p class="description">
        <p>Date d'emprunt : <?php echo $livre["date_emprunt"]; ?></p>

        <p>Date retour : <?php echo $livre["date_retour"]; ?></p>


        </div>
    </div>
    <?php
}
?>
</main>



</body>

</html>