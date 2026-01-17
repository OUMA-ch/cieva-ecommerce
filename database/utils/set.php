<?php
include_once __DIR__ . '/../connexion.php';

function set($sql, $params = null) {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute($params);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}
