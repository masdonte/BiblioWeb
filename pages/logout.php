<?php
session_start();
session_destroy();

// Attention ici : il y avait un espace entre "Location:" et l'URL
header("Location: /BiblioWeb/index.php?page=home&logout=success"); // https://code.whatever.social/questions/34377594/php-header-location-redirect-success-login-to-member-php

exit(); // ← Ajoute toujours exit() après header() pour arrêter le script
?>