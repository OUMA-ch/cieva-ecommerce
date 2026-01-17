<?php
include_once __DIR__ . '/../../../database/utils/getAll.php';

// Produits
$produits = getAll("SELECT * FROM produits");
// une image de produit
$images = getAll("SELECT * FROM images_produit LIMIT 1");
$image_produit = $images[0]['img_url'];
?>
<section class="list-products">
    <h1>Liste des produits</h1>
    <?php if(count($produits) > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $produit) : ?>
                    <tr>
                        <td><?= $produit['id'] ?></td>
                        <td><?= $produit['nom'] ?></td>
                        <td><?= $produit['prix'] ?></td>
                        <td><?= $produit['stock'] ?></td>
                        <td>
                            <?php if (!empty($image_produit)) : ?>
                                <img src="<?= $image_produit ?>" alt="<?= $produit['nom'] ?>" width="50">
                            <?php else : ?>
                                <span>Aucune image</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?section=edit-product&id=<?= $produit['id'] ?>">Modifier</a>
                            <a class="delete" href="actions/delete-product.php?id=<?= $produit['id'] ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucun produit disponible. <a href="?section=add-product">Ajouter un produit</a></p>
    <?php endif; ?>
</section>
