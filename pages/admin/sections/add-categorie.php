<section class="add-categorie">
    <h1>Ajouter une categorie</h1>
    <form action="actions/add-categorie.php" method="POST" enctype="multipart/form-data">
        <div class="input-container">
            <label for="nom">Nom de la categorie :</label>
            <input type="text" id="nom" name="nom" required placeholder="Ex: Chaussures" pattern="^[A-Za-z0-9_ ]+$" title="Le nom ne peut contenir que des lettres, des chiffres, des underscores et des espaces">
        </div>

        <div class="input-container">
            <label for="image_url">Image :</label>
            <input type="file" id="image_url" name="image_url" accept="image/*">
        </div>

        <div class="input-container">
            <label for="description">Description :</label>
            <textarea name="description" id="description" rows="5" required placeholder="Ex: Les chaussures sont des vêtements de pied qui sont portés pour se protéger les pieds"></textarea>
        </div>

        <button type="submit">Ajouter cette categorie</button>
    </form>
</section>
