<?php

require_once __DIR__ . '/../database/utils/get.php';
require_once __DIR__ . '/../database/utils/getAll.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'];

if (isset($user)) {
    $produits_preferes = getAll("SELECT * FROM produits_preferes WHERE id_utilisateur = :id_utilisateur", ['id_utilisateur' => $user['id']]);
} else {
    $produits_preferes = [];
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once __DIR__ . '/includes/head.php' ?>
    <title>Produits preferes</title>
    <link rel="stylesheet" href="/src/css/product-prefered.css">
</head>

<body>
    <?php include_once __DIR__ . '/includes/header.php' ?>
    <main>
        <div class="produits">
            <h1>Produits preferes</h1>
            <?php if (count($produits_preferes) > 0) : ?>
                <ul>
                    <?php foreach ($produits_preferes as $produit) : ?>
                        <?php
                        // recuper le produit en question
                        $produit_info = get("SELECT * FROM produits WHERE id = :id", ['id' => $produit['id_produit']]);
                        ?>
                        <li>
                            <a href="/pages/produit-review.php?id=<?= $produit_info['id'] ?>">
                                <?php
                                $images = getAll("SELECT * FROM images_produit WHERE id_produit = :id_produit", ['id_produit' => $produit_info['id']]);
                                $produit_info['image_url'] = $images[0]['img_url'] ?? '';
                                ?>
                                <img src="<?= $produit_info['image_url'] ?>" alt="<?= $produit_info['nom'] ?>">
                                <?= $produit_info['nom'] ?> (<?= number_format($produit_info['prix'], 2, ',', ' ') ?> Dhs)
                            </a>
                            <form action="actions/remove-prefered-product.php" method="post">
                                <input type="hidden" name="id_produit" value="<?= $produit_info['id'] ?>">
                                <button type="submit">Supprimer des favoris</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>Vous n'avez pas encore ajout de produit vos favoris.</p>
            <?php endif; ?>
        </div>
    </main>
    <?php include_once __DIR__ . '/includes/footer.php' ?>
</body>

</html>