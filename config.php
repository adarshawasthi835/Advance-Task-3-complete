<?php
// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=blog;charset=utf8", "root", "");

// Error handling ON
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Session start
session_start();
?>