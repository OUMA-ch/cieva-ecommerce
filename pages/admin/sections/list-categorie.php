<?php
include_once __DIR__ . '/../../../database/utils/getAll.php';
include_once __DIR__ . '/../../../database/utils/showErrors.php';

// Récupérer toutes les catégories
$categories = getAll("SELECT * FROM categories");
?>

</section>
<section class="list-categorie">
    <h1>Liste des categories</h1>
    <?php if(count($categories) > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $categorie) : ?>
                    <tr>
                        <td><?= $categorie['id'] ?></td>
                        <td><?= $categorie['nom'] ?></td>
                        <td><?= $categorie['description'] ?></td>
                        <td>
                            <img src="<?= $categorie['image_url'] ?>" alt="<?= $categorie['nom'] ?>" width="50">
                        </td>
                        <td>
                            <a href="?section=edit-categorie&id=<?= $categorie['id'] ?>">Modifier</a>
                            <a class="delete" href="actions/delete-categorie.php?id=<?= $categorie['id'] ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucune categorie disponible. <a href="?section=add-categorie">Ajouter une categorie</a></p>
    <?php endif; ?>
</section>
