<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../database/utils/get.php';
require_once __DIR__ . '/../../database/utils/set.php';
require_once __DIR__ . '/../../database/utils/showErrors.php';

if (isset($_POST['id_produit'])) {
    $id_produit = $_POST['id_produit'];
    $id_utilisateur = $_SESSION['user']['id'];

    // Check if the product is already in favorites
    $exists = get('SELECT * FROM produits_preferes WHERE id_utilisateur = :id_utilisateur AND id_produit = :id_produit', ['id_utilisateur' => $id_utilisateur, 'id_produit' => $id_produit]);

    if ($exists) {
        echo "Le produit est déjà dans vos favoris. <a href=\"/pages/produit-review.php?id=$id_produit\">Retourner au produit</a>";
        exit;
    }

    if (set('INSERT INTO produits_preferes (id_utilisateur, id_produit) VALUES (:id_utilisateur, :id_produit)', ['id_utilisateur' => $id_utilisateur, 'id_produit' => $id_produit])) {
        echo "Le produit a été ajouté à vos favoris ! <a href=\"/pages/produit-review.php?id=$id_produit\">Retourner au produit</a>";
        exit;
    } else {
        echo "Erreur lors de l'ajout du produit aux favoris. Veuillez réessayer ! <a href=\"/pages/produit-review.php?id=$id_produit\">Retourner au produit</a>";
        exit;
    }
}

