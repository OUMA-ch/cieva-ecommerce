<?php
include_once __DIR__ . '/../../../database/utils/set.php';
include_once __DIR__ . '/../../../database/utils/getAll.php';
include_once __DIR__ . '/../../../database/utils/showErrors.php';

// Récupération des données du produit
$id = intval($_POST['id']);
$nom = trim($_POST['nom']);
$prix = floatval($_POST['prix']);
$description = trim($_POST['description']);
$stock = intval($_POST['stock']);
$id_marque = intval($_POST['id_marque']);
$id_categories = $_POST['id_categorie'] ?? [];
$images = $_FILES['images'];

// Tableau des erreurs
$errors = [];

// Vérification des informations
if (empty($nom)) {
    $errors[] = "Le nom du produit est obligatoire.";
}

if ($prix <= 0) {
    $errors[] = "Le prix doit être supérieur à 0.";
}

if ($stock < 0) {
    $errors[] = "Le stock ne peut pas être négatif.";
}

// Vérification des erreurs
if (count($errors) > 0) {
    foreach ($errors as $error) {
        echo "$error<br>";
    }
    exit;
}

// Mettre à jour le produit
$params = [
    'id' => $id,
    'nom' => $nom,
    'prix' => $prix,
    'description' => $description,
    'stock' => $stock,
    'id_marque' => $id_marque,
];

$sql = "UPDATE produits SET nom = :nom, prix = :prix, description = :description, stock = :stock, id_marque = :id_marque WHERE id = :id";
if (set($sql, $params)) {
    // Supprimer les anciennes catégories
    set("DELETE FROM produits_categories WHERE id_produit = :id_produit", ['id_produit' => $id]);

    // Insertion des nouvelles catégories
    foreach ($id_categories as $id_categorie) {
        $sql = "INSERT INTO produits_categories (id_produit, id_categorie) VALUES (:id_produit, :id_categorie)";
        $params = [
            'id_produit' => $id,
            'id_categorie' => intval($id_categorie),
        ];
        set($sql, $params);
    }

    // Suppression des anciennes images
    $old_images = getAll("SELECT img_url FROM images_produit WHERE id_produit = :id_produit", ['id_produit' => $id]);
    foreach ($old_images as $old_image) {
        $image_path = __DIR__ . "/../../../" . $old_image['img_url'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    set("DELETE FROM images_produit WHERE id_produit = :id_produit", ['id_produit' => $id]);

    // Stockage des nouvelles images
    $dir = __DIR__ . "/../../../assets/images/produits";
    $images_urls = [];
    foreach ($images['name'] as $key => $image) {
        $unique_id = uniqid();
        $image_url = "/assets/images/produits/$unique_id-$image";
        move_uploaded_file($images['tmp_name'][$key], "$dir/$unique_id-$image");
        $images_urls[] = $image_url;
    }

    // Insertion des nouvelles images
    foreach ($images_urls as $image_url) {
        $sql = "INSERT INTO images_produit (img_url, id_produit) VALUES (:img_url, :id_produit)";
        $params = [
            'img_url' => $image_url,
            'id_produit' => $id,
        ];
        set($sql, $params);
    }

    echo "Produit mis à jour avec succès!";
} else {
    echo "Erreur lors de la mise à jour du produit. Veuillez réessayer!";
}

