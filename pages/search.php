<?php

include '../database/utils/showErrors.php';
include '../database/utils/get.php';
include '../database/utils/getAll.php';
include '../database/utils/set.php';


$requeteRecherche = $_GET['search'] ?? '';
if (!empty($requeteRecherche)) {
    // Ajout le terme de recherche a la base de donnee
    set("INSERT INTO terme_recherche (termes) VALUES (:termes)", ['termes' => $requeteRecherche]);

    // recuper les resultats de la recherche
    $resultats = getAll("SELECT * FROM produits WHERE nom LIKE :termes", ['termes' => "%$requeteRecherche%"]);
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once __DIR__ . '/includes/head.php' ?>
    <title>Recherche sur <?= htmlspecialchars($requeteRecherche) ?></title>
    <link rel="stylesheet" href="/src/css/search.css">
</head>

<body>
    <?php include_once __DIR__ . '/includes/header.php' ?>
    <main>
        <div class="produits">
            <h1>Recherche sur "<?= htmlspecialchars($requeteRecherche) ?>"</h1>
            <div class="container">
                <?php if (empty($resultats)) : ?>
                    <p>Aucun résultat trouvé pour "<?= htmlspecialchars($requeteRecherche) ?>"</p>
                <?php else : ?>
                    <?php foreach ($resultats as $product) : ?>
                        <?php
                        // une image de chaque produit
                        $images = getAll("SELECT * FROM images_produit WHERE id_produit = :id_produit", ['id_produit' => $product['id']]);
                        $product['image_url'] = $images[0]['img_url'];
                        ?>
                        <a class="produit" href="/pages/produit-review.php?id=<?= $product['id'] ?>">
                            <div class="img-produit">
                                <img src="<?= $product['image_url'] ?>" alt="">
                            </div>
                            <div class="info">
                                <h1><?= $product['nom'] ?></h1>
                                <div class="conteneur-prix">
                                    <p class="ancien-prix"><?= $product['ancien_prix'] ?> Dhs</p>
                                    <p class="nouveau-prix"><?= $product['prix'] ?> Dhs</p>
                                    <span class="remise"><?= round(100 - ($product['prix'] / $product['ancien_prix']) * 100) ?>%</span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include_once __DIR__ . '/includes/footer.php' ?>
</body>

</html>