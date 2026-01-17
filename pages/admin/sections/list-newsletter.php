<section class="list-newsletter">
    <h1>Liste des newsletters</h1>
    <?php
    include_once __DIR__ . '/../../../database/utils/getAll.php';
    $newsletters = getAll("SELECT * FROM newsletter");
    if (count($newsletters) > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Date d'inscription</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($newsletters as $newsletter) : ?>
                    <tr>
                        <td><?= $newsletter['id'] ?></td>
                        <td><?= $newsletter['nom'] ?></td>
                        <td><?= $newsletter['prenom'] ?></td>
                        <td><?= $newsletter['email'] ?></td>
                        <td><?= date('d/m/Y H:i:s', strtotime($newsletter['date_inscription'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucune newsletter disponible.</p>
    <?php endif; ?>
</section>
