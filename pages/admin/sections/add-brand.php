<section class="add-brand">
    <h1>Ajouter une marque</h1>
    <form action="actions/add-brand.php" method="post" enctype="multipart/form-data">
        <div class="input-container">
            <label for="name">Nom : <span>*</span></label>
            <input type="text" name="name" id="name" maxlength="255" required placeholder="Ex: Nike" pattern="[A-Za-z0-9_]+" title="Le nom ne peut contenir que des lettres, des chiffres et des underscores">
        </div>
        <div class="input-container">
            <label for="logo">Logo : <span>*</span></label>
            <input type="file" name="logo" id="logo" accept="image/*" required>
            <p>Le logo doit etre un fichier image (jpeg, png, gif, jpg, svg)</p>
        </div>
        <div class="input-container">
            <label for="description">Description : <span>*</span></label>
            <textarea name="description" id="description" rows="3" minlength="10" maxlength="512" required placeholder="Ex: Marque de chaussures de sport"></textarea>
            <p>La description doit contenir au moins 10 caracteres et au maximum 512 caracteres</p>
        </div>
        <button type="submit">Ajouter cette marque</button>
        <button type="reset">Vider le formulaire</button>
    </form>
</section>

