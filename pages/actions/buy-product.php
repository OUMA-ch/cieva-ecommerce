<?php
include_once __DIR__ . '/../../../database/utils/set.php';

$id_produit = intval($_POST['id_produit'] ?? 0);

if ($id_produit > 0) {
    $produit = get("SELECT * FROM produits WHERE id = :id", ['id' => $id_produit]);
    if ($produit) {
        $sql = "INSERT INTO commandes (id_utilisateur, id_produit, date_commande) VALUES (:id_utilisateur, :id_produit, NOW())";
        $params = [
            'id_utilisateur' => $_SESSION['user']['id'],
            'id_produit' => $id_produit,
        ];
        set($sql, $params);
        header('Location: /pages/commandes.php');
        exit;
    }
}
