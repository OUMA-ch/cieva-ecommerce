<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../database/utils/showErrors.php';
include_once __DIR__ . '/../../database/utils/set.php';

if (isset($_POST['id_produit'])) {
    $id_produit = intval($_POST['id_produit']);
    if ($id_produit > 0) {
        set("DELETE FROM produits_preferes WHERE id_produit = :id_produit AND id_utilisateur = :id_utilisateur", ['id_produit' => $id_produit, 'id_utilisateur' => $_SESSION['user']['id']]);
        echo "Le produit a bien été supprimé des favoris.<br>
            <a href=\"javascript:history.back()\">Retour</a> <br>
            <a href=\"/pages/favoris.php\">Favoris</a>";
        exit;
    }
} else {
    echo "Erreur : l'ID du produit est manquant.<br><a href=\"javascript:history.back()\">Retour</a>";
    exit;
}
