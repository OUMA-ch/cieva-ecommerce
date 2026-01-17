<?php
// Inclure les fichiers nécessaires
include_once __DIR__ . '/../database/utils/showErrors.php';
include_once __DIR__ . '/../database/utils/get.php';
include_once __DIR__ . '/../database/utils/getAll.php';

// Récupérer l'ID du produit à partir de l'URL
$product_id = intval($_GET['id'] ?? 0);

// Vérifier si l'ID est valide
if ($product_id > 0) {
    // Vérifier si le produit existe en base de données
    $product_sql = "SELECT * FROM produits WHERE id = :id";
    $product_params = ['id' => $product_id];
    $product = get($product_sql, $product_params);
    if (!$product) {
        echo "Produit introuvable. <a href='javascript:history.back()'>Retour</a>";
        exit;
    }

    // Récupérer les images associées au produit
    $images_sql = "SELECT * FROM images_produit WHERE id_produit = :id_produit";
    $images_params = ['id_produit' => $product_id];
    $images = getAll($images_sql, $images_params);

    // Récupérer les catégories associées au produit
    $categories_sql = "SELECT c.nom FROM produits_categories pc
                       JOIN categories c ON pc.id_categorie = c.id
                       WHERE pc.id_produit = :id_produit";
    $categories_params = ['id_produit' => $product_id];
    $categories = getAll($categories_sql, $categories_params);

    // Récupérer la marque du produit
    $brand_sql = "SELECT * FROM marques WHERE id = :id_marque";
    $brand_params = ['id_marque' => $product['id_marque']];
    $brand = get($brand_sql, $brand_params);
} else {
    echo "Produit introuvable. <a href='javascript:history.back()'>Retour</a>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once __DIR__ . '/includes/head.php'; ?>
    <title>Détails du produit</title>
    <link rel="stylesheet" href="/src/css/produit-review.css" type="text/css">
</head>

<body>
    <?php include_once __DIR__ . '/includes/header.php'; ?>
    <main>
        <h1>Produit : <?php echo htmlspecialchars($product['nom']); ?></h1>

        <div class="product-details">
            <!-- Affichage des informations du produit -->
            <div class="product-info">
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <p><strong>Prix:</strong> <?php echo number_format($product['prix'], 2); ?> MAD</p>
                <p><strong>Ancien prix:</strong> <?php echo number_format($product['ancien_prix'], 2); ?> MAD</p>
                <p><strong>Stock:</strong> <?php echo $product['stock']; ?></p>
                <p><strong>Marque:</strong> <?php echo htmlspecialchars($brand['nom']); ?></p>
                <p><strong>Catégories:</strong>
                    <?php
                    foreach ($categories as $category) {
                        echo htmlspecialchars($category['nom']) . ', ';
                    }
                    ?>
                </p>
            </div>

            <!-- Affichage des images du produit -->
            <div>
                <h3>Images du produit</h3>
                <div class="product-images">
                    <?php foreach ($images as $image): ?>
                        <img src="<?php echo htmlspecialchars($image['img_url']); ?>" alt="Image du produit" width="200">
                    <?php endforeach; ?>
                </div>
                <div class="product-actions">
                    <?php if (isset($_SESSION['user'])): ?>
                        <form action="actions/add-to-cart.php" method="post">
                            <input type="hidden" name="id_produit" value="<?php echo $product_id; ?>">
                            <div>
                                <label for="quantite">Quantité:</label>
                                <input type="int" name="quantite" value="1" step="1" min="1">
                            </div>
                            <button type="submit">Ajouter au panier</button>
                        </form>
                        <form action="actions/add-to-favorites.php" method="post">
                            <input type="hidden" name="id_produit" value="<?php echo $product_id; ?>">
                            <button type="submit">Ajouter aux favoris</button>
                        </form>
                    <?php else: ?>
                        <p>Vous devez être connecté pour ajouter le produit au panier ou l'acheter. <a href="/pages/connexion.php">Se connecter</a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <?php include_once __DIR__ . '/includes/footer.php'; ?>
</body>

</html>