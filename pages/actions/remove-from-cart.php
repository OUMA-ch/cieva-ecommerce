<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../../database/utils/set.php';

$id_produit = intval($_POST['id_produit'] ?? 0);
$id_utilisateur = 0;
if (isset($_SESSION['user']['id'])) {
    $id_utilisateur = $_SESSION['user']['id'];
} else {
    echo "Erreur : vous devez être connecté pour supprimer un produit du panier. <a href=\"/pages/connexion.php\">Se connecter</a>";
    exit;
}

if ($id_produit > 0) {
    $sql = "DELETE FROM panier WHERE id_utilisateur = :id_utilisateur AND id_produit = :id_produit";
    $params = [
        'id_utilisateur' => $id_utilisateur,
        'id_produit' => $id_produit,
    ];
    set($sql, $params);
    echo "Le produit a bien été supprimé du panier.<br>
        <a href=\"javascript:history.back()\">Retour</a>
        <a href=\"/pages/panier.php\">Panier</a>";
    exit;
} else {
    echo "Erreur : l'ID du produit est manquant.<br><a href=\"javascript:history.back()\">Retour</a>";
    exit;
}
