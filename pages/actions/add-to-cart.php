<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// include_once __DIR__ . '/../../database/utils/showErrors.php';
include_once __DIR__ . '/../../database/utils/get.php';
include_once __DIR__ . '/../../database/utils/set.php';

$id_produit = intval($_POST['id_produit'] ?? 0);
$quantite = intval($_POST['quantite'] ?? 0);

$id_utilisateur = 0;
if (isset($_SESSION['user']['id'])) {
    $id_utilisateur = $_SESSION['user']['id'];
} else {
    echo "Erreur : vous devez être connecté pour ajouter un produit au panier. <a href=\"/pages/connexion.php\">Se connecter</a>";
    exit;
}

if ($id_produit > 0) {
    $produit = get("SELECT * FROM produits WHERE id = :id", ['id' => $id_produit]);
    if ($produit) {
        $panier_produit = get("SELECT * FROM panier WHERE id_utilisateur = :id_utilisateur AND id_produit = :id_produit", ['id_utilisateur' => $id_utilisateur, 'id_produit' => $id_produit]);
        if ($panier_produit) {
            $sql = "UPDATE panier SET quantite = quantite + :quantite WHERE id_utilisateur = :id_utilisateur AND id_produit = :id_produit";
            $params = [
                'id_utilisateur' => $id_utilisateur,
                'id_produit' => $id_produit,
                'quantite' => $quantite
            ];
        } else {
            $sql = "INSERT INTO panier (id_utilisateur, id_produit, quantite) VALUES (:id_utilisateur, :id_produit, :quantite)";
            $params = [
                'id_utilisateur' => $id_utilisateur,
                'id_produit' => $id_produit,
                'quantite' => $quantite
            ];
        }
        set($sql, $params);
        echo "Le produit a bien ajouté au panier.<br>
            <a href=\"javascript:history.back()\">Retour</a> <br>
            <a href=\"/pages/panier.php\">Panier</a>";
        exit;
    } else {
        echo "Erreur : le produit n'existe pas.<br><a href=\"/pages/produit-review.php?id=$id_produit\">Retourner au produit</a>";
        exit;
    }
} else {
    echo "Erreur : le produit n'existe pas.<br><a href=\"/pages/produit-review.php?id=$id_produit\">Retourner au produit</a>";
    exit;
}


