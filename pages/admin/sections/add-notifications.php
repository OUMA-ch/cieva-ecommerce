<section class="add-notifications">
    <h1>Ajouter une notification</h1>
    <form action="actions/add-notifications.php" method="POST">
        <div class="input-container">
            <label for="content">Contenu de la notification :</label>
            <textarea name="content" id="content" rows="5" required placeholder="Ex: Nous sommes désolés, mais il y a eu un problème lors de la livraison de votre commande."></textarea>
        </div>

        <button type="submit">Ajouter cette notification</button>
    </form>
</section>
