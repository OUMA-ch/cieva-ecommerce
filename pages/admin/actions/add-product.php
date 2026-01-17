<?php
include_once __DIR__ . '/../../../database/utils/set.php';
include_once __DIR__ . '/../../../database/utils/showErrors.php';

// Récupération des données du produit
$nom = trim($_POST['nom']);
$prix = floatval($_POST['prix']);
$ancien_prix = isset($_POST['ancien_prix']) ? floatval($_POST['ancien_prix']) : null;
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

if ($ancien_prix !== null && $ancien_prix <= $prix) {
    $errors[] = "L'ancien prix doit être supérieur au prix actuel.";
}

// Vérification des erreurs
if (count($errors) > 0) {
    foreach ($errors as $error) {
        echo "$error<br>";
    }
    exit;
}

// Stockage des images
$dir = __DIR__ . "/../../../assets/images/produits";
$images_urls = [];
foreach ($images['name'] as $key => $image) {
    $unique_id = uniqid();
    $image_url = "/assets/images/produits/$unique_id-$image";
    move_uploaded_file($images['tmp_name'][$key], "$dir/$unique_id-$image");
    $images_urls[] = $image_url;
}

// Préparation des paramètres
$params = [
    'nom' => $nom,
    'prix' => $prix,
    'ancien_prix' => $ancien_prix,
    'description' => $description,
    'stock' => $stock,
    'id_marque' => $id_marque,
];

// Insertion du produit
$sql = "INSERT INTO produits (nom, prix, ancien_prix, description, stock, id_marque) 
        VALUES (:nom, :prix, :ancien_prix, :description, :stock, :id_marque)";

if (set($sql, $params)) {
    $produit_id = set("SELECT LAST_INSERT_ID()", []);
    // Insertion des catégories
    foreach ($id_categories as $id_categorie) {
        $sql = "INSERT INTO produits_categories (id_produit, id_categorie) VALUES (:id_produit, :id_categorie)";
        $params = [
            'id_produit' => $produit_id,
            'id_categorie' => intval($id_categorie),
        ];
        set($sql, $params);
    }

    // Insertion des images
    foreach ($images_urls as $image_url) {
        $sql = "INSERT INTO images_produit (img_url, id_produit) VALUES (:img_url, :id_produit)";
        $params = [
            'img_url' => $image_url,
            'id_produit' => $produit_id,
        ];
        set($sql, $params);
    }

    echo "Produit ajouté avec succès!";
} else {
    echo "Erreur lors de l'ajout du produit. Veuillez réessayer!";
}

