<?php
include_once __DIR__ . '/../connexion.php';

function getAll($sql, $params = null) {
    global $pdo;

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt->closeCursor(); // Réinitialise le curseur

        return $results;
    } catch (PDOException $e) {
        echo 'Erreur de requête PDO : ' . $e->getMessage();
        return [];
    } catch (Exception $e) {
        echo 'Erreur de paramètre : ' . $e->getMessage();
        return [];
    }
}
