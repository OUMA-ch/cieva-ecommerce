<section class="list-orders">
    <h1>Liste des commandes</h1>
    <?php
    include_once __DIR__ . '/../../../database/utils/getAll.php';

    // Récupérer toutes les commandes
    $commandes = getAll("SELECT * FROM commandes ORDER BY id DESC");

    ?>
    <?php if (count($commandes) > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Client</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commandes as $commande) : ?>
                    <?php
                    include_once __DIR__ . '/../../../database/utils/get.php';

                    // Récupérer le client associer
                    $client = get("SELECT * FROM clients WHERE id = ?", [$commande['id_utilisateur']]);
                    $commande['prenom'] = $client['prenom'];
                    $commande['nom'] = $client['nom'];
                    ?>
                    <tr>
                        <td><?= $commande['id'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($commande['date_creation'])) ?></td>
                        <td><?= $commande['prenom'] . ' ' . $commande['nom'] ?></td>
                        <td><?= number_format($commande['montant'], 2) ?> &euro;</td>
                        <td><?= $commande['statut'] ?></td>
                        <td>
                            <a href="?section=view-order&id=<?= $commande['id'] ?>">Voir</a>
                            <a class="delete" href="actions/delete-order.php?id=<?= $commande['id'] ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucune commande disponible. <a href="?section=add-order">Ajouter une commande</a></p>
    <?php endif; ?>
</section>