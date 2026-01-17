<?php
include_once __DIR__ . '/../../../database/utils/set.php';
include_once __DIR__ . '/../../../database/utils/getAll.php';
include_once __DIR__ . '/../../../database/utils/showErrors.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    // Suppression des catégories liées
    $sql = "DELETE FROM produits_categories WHERE id_produit = :id_produit";
    $params = ['id_produit' => $id];

    if (!set($sql, $params)) {
        echo "Erreur lors de la suppression des catégories liées au produit. Veuillez réessayer !<br><a href=\"../?section=list-products\">Retourner à la liste des produits</a>";
    }

    // Suppression des images du produit
    $sql = "SELECT img_url FROM images_produit WHERE id_produit = :id_produit";
    $params = ['id_produit' => $id];
    $images = getAll($sql, $params);

    foreach ($images as $image) {
        $image_url = __DIR__ . "/../../../" . $image['img_url'];
        if (file_exists($image_url)) {
            unlink($image_url);
        }
    }

    // Suppression des images du produit en base de données
    $sql = "DELETE FROM images_produit WHERE id_produit = :id_produit";
    $params = ['id_produit' => $id];
    if (!set($sql, $params)) {
        echo "Erreur lors de la suppression des images du produit. Veuillez réessayer !<br><a href=\"../?section=list-products\">Retourner à la liste des produits</a>";
    }


    // Suppression du produit
    $sql = "DELETE FROM produits WHERE id = :id";
    $params = ['id' => $id];

    if (set($sql, $params)) {
        echo "Le produit a été supprimé avec succès !<br><a href=\"../?section=list-products\">Retourner à la liste des produits</a>";
    } else {
        echo "Erreur lors de la suppression du produit. Veuillez réessayer !<br><a href=\"../?section=list-products\">Retourner à la liste des produits</a>";
    }
} else {
    echo "Erreur : l'ID du produit est manquant.<br><a href=\"../?section=list-products\">Retourner à la liste des produits</a>";
}


