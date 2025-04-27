<?php
session_start();
session_destroy();
header("Location: /BiblioWeb/index.php?page=home&logout=success"); // https://code.whatever.social/questions/34377594/php-header-location-redirect-success-login-to-member-php

exit(); 
?>