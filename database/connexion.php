<?php
// importer les infos de la base de donnee
include_once 'config.php';
// connexion a la base de donnee
try {
    // connexion PDO
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbName;charset=utf8", $username, $password);

    // Configuration des options PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activer les exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Mode de récupération des données
} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit; // Arrêter le script en cas d'erreur
}