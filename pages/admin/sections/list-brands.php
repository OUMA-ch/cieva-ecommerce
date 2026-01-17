<?php
include_once __DIR__ . '/../../../database/utils/getAll.php';

// Récupérer toutes les marques
$marques = getAll("SELECT * FROM marques");
?>
<section class="list-brands">
    <h1>Liste des marques</h1>
    <?php if (count($marques) > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Logo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($marques as $marque) : ?>
                    <tr>
                        <td><?= $marque['id'] ?></td>
                        <td><?= $marque['nom'] ?></td>
                        <td><?= $marque['description'] ?></td>
                        <td><img src="<?= $marque['logo_url'] ?>" alt="<?= $marque['nom'] ?>" width="50"></td>
                        <td>
                            <a href="?section=edit-brand&id=<?= $marque['id'] ?>">Modifier</a>
                            <a class="delete" href="actions/delete-brand.php?id=<?= $marque['id'] ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucune marque disponible. <a href="?section=add-brand">Ajouter une marque</a></p>
    <?php endif; ?>
</section>

