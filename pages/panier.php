<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../database/utils/showErrors.php';
include_once __DIR__ . '/../database/utils/get.php';
include_once __DIR__ . '/../database/utils/getAll.php';

$panier = [];
if (isset($_SESSION['user'])) {
    $sql = "SELECT * 
            FROM panier
            WHERE id_utilisateur = :id_utilisateur";
    $panier = getAll($sql, ['id_utilisateur' => $_SESSION['user']['id']]);
} else {
    echo "Vous devez  tre connect  pour acc der au panier. <a href=\"/pages/connexion.php\">Se connecter</a>";
    exit;
}
$total = 0;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once __DIR__ . '/includes/head.php' ?>
    <title>Panier</title>
    <link rel="stylesheet" href="/src/css/panier.css" type="text/css">
</head>

<body>
    <?php include_once __DIR__ . '/includes/header.php' ?>
    <main>
        <?php if (count($panier) > 0) : ?>
            <h1>Panier</h1>
            <div class="conteneur-panier">
                <?php foreach ($panier as $produit) : ?>
                    <?php
                    $produit_info = get("SELECT * FROM produits WHERE id = :id", ['id' => $produit['id_produit']]);
                    // une image de chaque produit
                    $images = getAll("SELECT * FROM images_produit WHERE id_produit = :id_produit", ['id_produit' => $produit_info['id']]);
                    $produit_info['image_url'] = $images[0]['img_url'] ?? '';
                    $total += $produit_info['prix'] * $produit['quantite'];
                    ?>
                    <div class="produit-panier">
                        <img src="<?= $produit_info['image_url'] ?>" alt="">
                        <div class="info">
                            <h1><?= $produit_info['nom'] ?></h1>
                            <p><?= $produit_info['prix'] ?> Dhs</p>
                            <p>Quantite : <?= $produit['quantite'] ?></p>
                            <p>Total : <?= number_format($produit_info['prix'] * $produit['quantite'], 2, ',', ' ') ?></p>
                            <div class="actions">
                                <form action="actions/remove-from-cart.php" method="post">
                                    <input type="hidden" name="id_produit" value="<?= $produit_info['id'] ?>">
                                    <button type="submit">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="total">
                    <h2>Total payer</h2>
                    <p><?= number_format($total, 2, ',', ' ') ?> Dhs</p>
                    <!-- achter les produits -->
                    <a href="buy-product.php">Acheter ces produit</a>
                </div>
            </div>
        <?php else : ?>
            <p>Votre panier est vide. <a href="/index.php">Continuer vos achats</a></p>
        <?php endif; ?>
    </main>
    <?php include_once __DIR__ . '/includes/footer.php' ?>
</body>

</html>