<?php
include_once __DIR__ . '/../../../database/utils/getAll.php';

// Marques
$marques = getAll("SELECT * FROM marques");
// Categories
$categories = getAll("SELECT * FROM categories");
?>
<section class="add-product">
    <h1>Ajouter un produit</h1>
    <form action="actions/add-product.php" method="POST" enctype="multipart/form-data" class="form-container">
        <h2>Informations du produit</h2>

        <div class="input-container">
            <label for="nom">Nom du produit :</label>
            <input type="text" id="nom" name="nom" required placeholder="Ex: Meuble TV" pattern="[A-Za-z0-9_ ]+" title="Le nom ne peut contenir que des lettres, des chiffres et des underscores">
        </div>

        <div class="input-container">
            <label for="prix">Prix :</label>
            <input type="number" id="prix" name="prix" step="0.01" required placeholder="Ex: 199.99" pattern="[0-9]+(\.[0-9]{1,2})?" title="Le prix doit contenir au maximum 2 décimales">
        </div>

        <div class="input-container">
            <label for="ancien_prix">Ancien prix :</label>
            <input type="number" id="ancien_prix" name="ancien_prix" step="0.01" placeholder="Ex: 249.99" pattern="[0-9]+(\.[0-9]{1,2})?" title="L'ancien prix doit contenir au maximum 2 décimales">
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
            <textarea id="description" name="description" placeholder="Ex: Meuble TV en bois avec 2 tiroirs"></textarea>
        </div>

        <div class="input-container">
            <label for="stock">Stock :</label>
            <input type="number" id="stock" name="stock" required placeholder="Ex: 5" pattern="[1-9][0-9]*" title="Le stock doit être un nombre entier strictement positif">
        </div>

        <div class="input-container">
            <label for="marque">Marque :</label>
            <?php if (count($marques) > 0) : ?>
                <select id="marque" name="id_marque" required>
                    <option value="" checked>Sélectionner une marque</option>
                    <?php foreach ($marques as $marque) : ?>
                        <option value="<?= $marque['id'] ?>"><?= $marque['nom'] ?></option>
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
            <?php if (count($categories) > 0) : ?>
                <select id="categorie" name="id_categorie[]" multiple required>
                    <option value="">Sélectionner une ou plusieurs catégories</option>
                    <?php foreach ($categories as $categorie) : ?>
                            <option value="<?= $categorie['id'] ?>"><?= $categorie['nom'] ?></option>
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
            <button type="submit">Ajouter le produit</button>
        </div>
</section>
