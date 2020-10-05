<?php
$pdo = new PDO('mysql:host=localhost;dbname=misc','fred','zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_WARNING);
?>