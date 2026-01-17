<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Inclure les fichiers nécessaires
include_once __DIR__ . '/../database/utils/showErrors.php';
include_once __DIR__ . '/../database/utils/getAll.php';
include_once __DIR__ . '/../database/utils/get.php';
include_once __DIR__ . '/../database/utils/set.php';

// Récupérer l'ID utilisateur via la session
$id_utilisateur = $_SESSION['user']['id'] ?? 0;
if ($id_utilisateur == 0) {
    echo "Erreur : vous devez vous connecter pour acheter des produits.<br><a href=\"/pages/connexion.php\">Se connecter</a>";
    exit;
}

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

$produits = [];
foreach ($panier as $produit) {
    $produit_info = get("SELECT * FROM produits WHERE id = :id", ['id' => $produit['id_produit']]);
    $produit_info['quantite'] = $produit['quantite'];
    // image de produit
    $images = getAll("SELECT * FROM images_produit WHERE id_produit = :id_produit", ['id_produit' => $produit_info['id']]);
    $produit_info['img_url'] = $images[0]['img_url'] ?? '';
    $produits[] = $produit_info;
    $total += $produit_info['prix'] * $produit['quantite'];
}

// Vérifier si la commande est soumise
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insérer les détails de la commande
    foreach ($panier as $produit) {
        $id_details_commande = set(
            "INSERT INTO details_commande (id_produit, quantite_produit) VALUES (:id_produit, :quantite_produit)",
            [
                'id_produit' => $produit['id'],
                'quantite_produit' => $produit['quantite']
            ]
        );

        // Insérer la commande
        $id_commande = set(
            "INSERT INTO commandes (id_utilisateur, id_details_commande, statut) VALUES (:id_utilisateur, :id_details_commande, 'en_attente')",
            [
                'id_utilisateur' => $id_utilisateur,
                'id_details_commande' => $id_details_commande
            ]
        );

        // Insérer la méthode de paiement
        $id_methode_paiement = set(
            "INSERT INTO methode_paiement (id_commande, id_utilisateur, type_paiement) VALUES (:id_commande, :id_utilisateur, :type_paiement)",
            [
                'id_commande' => $id_commande,
                'id_utilisateur' => $id_utilisateur,
                'type_paiement' => $_POST['type_paiement']
            ]
        );
    }

    // Vider le panier
    set("DELETE FROM panier WHERE id_utilisateur = :id_utilisateur", ['id_utilisateur' => $id_utilisateur]);

    echo "<p>Votre commande a été passée avec succès.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once __DIR__ . '/includes/head.php' ?>
    <title>Commande</title>
    <link rel="stylesheet" href="/src/css/buy-product.css" type="text/css">
</head>

<body>
    <?php include_once __DIR__ . '/includes/header.php' ?>
    <main>
        <h1>Finaliser votre commande</h1>

        <?php if (count($produits) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Image</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Sous-total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits as $produit): ?>
                        <tr>
                            <td><?= $produit['nom'] ?></td>
                            <td><img src="<?= $produit['img_url'] ?>" alt="<?= $produit['nom'] ?>" width="50"></td>
                            <td><?= number_format($produit['prix'], 2, ',', ' ') ?> Dhs</td>
                            <td><?= $produit['quantite'] ?></td>
                            <td><?= number_format($produit['prix'] * $produit['quantite'], 2, ',', ' ') ?> Dhs</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total">
                <h2>Total à payer : <?= number_format($total, 2, ',', ' ') ?> Dhs</h2>
                <form method="post">
                    <label for="type_paiement">Méthode de paiement :</label>
                    <select name="type_paiement" id="type_paiement">
                        <option value="carte_bancaire">Carte bancaire</option>
                        <option value="paypal">PayPal</option>
                    </select><br>
                    <button type="submit">Passer la commande</button>
                </form>
            </div>
        <?php else: ?>
            <p>Votre panier est vide. <a href="/index.php">Continuer vos achats</a></p>
        <?php endif; ?>
    </main>
    <?php include_once __DIR__ . '/includes/footer.php'; ?>
</body>

</html>
