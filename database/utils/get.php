<?php
include_once __DIR__ . '/../connexion.php';
function get($sql, $params = null) {
    global $pdo;

    try {
        // Préparer et exécuter la requête
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        $stmt->closeCursor(); // Réinitialise le curseur

        return $result ?: null;
    } catch (PDOException $e) {
        echo 'Erreur de requête PDO : ' . $e->getMessage();
        return null;
    } catch (Exception $e) {
        echo 'Erreur de paramètre : ' . $e->getMessage();
        return null;
    }
}
