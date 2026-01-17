<?php
include_once __DIR__ . '/../database/utils/getAll.php';

function getProductsStartingWith($term) {
    $term = $term . '%'; // Append '%' for the LIKE clause to match starting characters
    $products = getAll("SELECT nom FROM produits WHERE nom LIKE :term", ['term' => $term]);
    return $products;
}

// Exemple d'utilisation
$term = $_GET['term'] ?? '';
if (!empty($term)) {
    $products = getProductsStartingWith($term);
    header('Content-Type: application/json');
    echo json_encode(['products' => $products]);
}
?>

