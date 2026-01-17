<?php
// recuperer l'id du produit
$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    echo "Erreur : l'ID du produit est manquant.<br><a href=\"../?section=list-products\">Retourner à la liste des produits</a>";
    exit;
}

include_once __DIR__ . '/../../../database/utils/get.php';
include_once __DIR__ . '/../../../database/utils/getAll.php';

// recuperer le produit
$produit = get("SELECT * FROM produits WHERE id = :id", ['id' => $id]);

if (!$produit) {
    echo "Erreur : le produit n'existe pas.<br><a href=\"../?section=list-products\">Retourner à la liste des produits</a>";
    exit;
}

// recuperer les categories
$categories_produit = getAll("SELECT id FROM categories WHERE id IN (SELECT id_categorie FROM produits_categories WHERE id_produit = :id)", ['id' => $id]);
$categories_produit_ids = array_column($categories_produit, 'id');

$tout_les_categories = getAll("SELECT * FROM categories");
// recuperer les marques
$marques = getAll("SELECT * FROM marques");
?>

<section class="edit-product">
    <h1>Modifier un produit</h1>
    <form action="actions/edit-product.php" method="POST" enctype="multipart/form-data" class="form-container">
        <h2>Informations du produit</h2>

        <input type="hidden" name="id" value="<?= $produit['id'] ?>" />

        <div class="input-container">
            <label for="nom">Nom du produit :</label>
            <input value="<?= $produit['nom'] ?>" type="text" id="nom" name="nom" required placeholder="Ex: Meuble TV" pattern="[A-Za-z0-9_ ]+" title="Le nom ne peut contenir que des lettres, des chiffres et des underscores">
        </div>

        <div class="input-container">
            <label for="prix">Prix :</label>
            <input value="<?= $produit['prix'] ?>" type="number" id="prix" name="prix" step="0.01" required placeholder="Ex: 199.99" pattern="[0-9]+(\.[0-9]{1,2})?" title="Le prix doit contenir au maximum 2 décimales">
        </div>

        <div class="input-container">
            <label for="ancien_prix">Ancien prix :</label>
            <input value="<?= $produit['ancien_prix'] ?>" type="number" id="ancien_prix" name="ancien_prix" step="0.01" placeholder="Ex: 249.99" pattern="[0-9]+(\.[0-9]{1,2})?" title="L'ancien prix doit contenir au maximum 2 décimales">
            <p id="reduction"></p>
            <script>
                const reduction_p = document.getElementById('reduction');
                const prix = document.getElementById('prix');
                const ancien_prix = document.getElementById('ancien_prix');
                const updateReduction = () => {
                    if (prix.value && ancien_prix.value) {
                        if (ancien_prix.value < prix.value) {
                            reduction_p.textContent = "L'ancien prix doit être supérieur au prix actuel.";
                        } else {
                            const percent = (1 - (prix.value / ancien_prix.value)) * 100;
                            reduction_p.textContent = `Réduction de ${percent.toFixed(2)}%`;
                        }
                    } else {
                        reduction_p.textContent = "";
                    }
                };
                prix.addEventListener('input', updateReduction);
                ancien_prix.addEventListener('input', updateReduction);
            </script>
        </div>

        <div class="input-container">
            <label for="description">Description :</label>
            <textarea id="description" name="description" placeholder="Ex: Meuble TV en bois avec 2 tiroirs"><?= $produit['description'] ?></textarea>
        </div>

        <div class="input-container">
            <label for="stock">Stock :</label>
            <input value="<?= $produit['stock'] ?>" type="number" id="stock" name="stock" required placeholder="Ex: 5" pattern="[1-9][0-9]*" title="Le stock doit être un nombre entier strictement positif">
        </div>

        <div class="input-container">
            <label for="marque">Marque :</label>
            <?php if (count($marques) > 0) : ?>
                <select id="marque" name="id_marque" required>
                    <option value="">Sélectionner une marque</option>
                    <?php foreach ($marques as $marque) : ?>
                        <option value="<?= $marque['id'] ?>" <?= $produit['id_marque'] == $marque['id'] ? 'selected' : '' ?>>
                            <?= $marque['nom'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p>Pour ajouter une nouvelle marque, <a href="?section=add-brand">cliquez ici</a>.</p>
            <?php else : ?>
                <div>
                    <p>Aucune marque n'est disponible. <a href="?section=add-brand">Ajouter une nouvelle marque</a></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="input-container">
            <label for="categorie">Catégories :</label>
            <?php if (count($tout_les_categories) > 0) : ?>
                <select id="categorie" name="id_categorie[]" multiple required>
                    <option value="">Sélectionner une ou plusieurs catégories</option>
                    <?php foreach ($tout_les_categories as $categorie) : ?>
                        <option value="<?= $categorie['id'] ?>" <?= in_array($categorie['id'], $categories_produit_ids) ? 'selected' : '' ?>>
                            <?= $categorie['nom'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p>Pour ajouter une nouvelle catégorie, <a href="?section=add-categorie">cliquez ici</a>.</p>
            <?php else : ?>
                <div>
                    <p>Aucune catégorie n'est disponible. <a href="?section=add-categorie">Ajouter une nouvelle catégorie</a></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="input-container">
            <label for="images">Images du produit :</label>
            <input type="file" id="images" name="images[]" multiple>
        </div>

        <div class="input-container">
            <button type="submit">Enregistrer les modifications</button>
        </div>
    </form>
</section>