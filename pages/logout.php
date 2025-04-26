<?php
session_start();
session_destroy();
header("/BiblioWeb/index.php?page=home");
?>
