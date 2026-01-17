<?php
include_once __DIR__ . '/../../../database/utils/getAll.php';
?>
<section class="welcome">
    <h1>Bienvenue sur le Tableau de Bord Admin!</h1>
    <p>Bonjour, Admin! Voici un aperçu rapide de votre magasin :</p>

    <div class="stats-grid">
        <div class="stat-card">
            <h2>Nombre de produits</h2>
            <p><?= count(getAll("SELECT * FROM produits")) ?></p>
        </div>
        <div class="stat-card">
            <h2>Nombre de commandes</h2>
            <p><?= count(getAll("SELECT * FROM commandes")) ?></p>
        </div>
        <div class="stat-card">
            <h2>Nombre de categories</h2>
            <p><?= count(getAll("SELECT * FROM categories")) ?></p>
        </div>
        <div class="stat-card">
            <h2>Nombre de marques</h2>
            <p><?= count(getAll("SELECT * FROM marques")) ?></p>
        </div>
        <div class="stat-card">
            <h2>Nombre d'utilisateurs</h2>
            <p><?= count(getAll("SELECT * FROM utilisateurs")) ?></p>
        </div>
    </div>

    <div class="actions">
        <h2>Actions Rapides</h2>
        <ul>
            <li><a href="?section=add-product">Ajouter un Produit</a></li>
            <li><a href="?section=list-orders">Voir les Commandes</a></li>
            <li><a href="?section=statistics">Statistiques</a></li>
        </ul>
    </div>
</section>


