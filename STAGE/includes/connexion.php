<?php
// Les paramètres de connexion à la base de données.  
$host = 'localhost:3306'; 
$dbname = 'boulangerie'; 
$username = 'wallon'; 
$password = 'sio'; 
try { 
// Création de la connexion PDO 
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password); // Configuration du mode d'erreur 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch(PDOException $e) { 
die("Erreur de connexion : " . $e->getMessage()); 
} 