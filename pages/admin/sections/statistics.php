<?php

include_once __DIR__ . '/../../../database/utils/getAll.php';
?>
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
        margin-bottom: 20px;
        justify-items: center;
    }
    .stat-card {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        text-align: center;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-card h2 {
        font-size: 18px;
        margin-bottom: 10px;
        color: #343a40;
        font-weight: 500;
    }

    .stat-card p {
        font-size: 24px;
        color: #007bff;
        font-weight: 600;
    }
</style>
<section class="statistics">
    <h1>Statistiques</h1>
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
        <div class="stat-card">
            <h2>Nombre de produits en stock</h2>
            <p><?= count(getAll("SELECT * FROM produits WHERE stock > 0")) ?></p>
        </div>
        <div class="stat-card">
            <h2>Nombre de produits hors stock</h2>
            <p><?= count(getAll("SELECT * FROM produits WHERE stock = 0")) ?></p>
        </div>
        <div class="stat-card">
            <h2>Nombre de commandes en attente</h2>
            <p><?= count(getAll("SELECT * FROM commandes WHERE statut = 'en attente'")) ?></p>
        </div>
        <div class="stat-card">
            <h2>Nombre de commandes en cours</h2>
            <p><?= count(getAll("SELECT * FROM commandes WHERE statut = 'en cours'")) ?></p>
        </div>
        <div class="stat-card">
            <h2>Nombre de commandes terminées</h2>
            <p><?= count(getAll("SELECT * FROM commandes WHERE statut = 'terminée'")) ?></p>
        </div>
        <div class="stat-card">
            <h2>Nombre de commandes annulées</h2>
            <p><?= count(getAll("SELECT * FROM commandes WHERE statut = 'annulée'")) ?></p>
        </div>
        <div class="stat-card">
            <h2>Nombre de commentaires</h2>
            <p><?= count(getAll("SELECT * FROM commentaires")) ?></p>
        </div>
        <div class="stat-card">
            <h2>Nombre de newsletters</h2>
            <p><?= count(getAll("SELECT * FROM newsletter")) ?></p>
        </div>
    </div>
</section>

