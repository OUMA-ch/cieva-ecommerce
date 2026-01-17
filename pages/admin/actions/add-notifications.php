<?php

include_once __DIR__ . '/../../../database/utils/set.php';

if (isset($_POST['content'])) {
    $content = htmlspecialchars($_POST['content']);

    $params = [
        'content' => $content
    ];

    if (set('INSERT INTO notifications (content) VALUES (:content)', $params)) {
        echo 'Notification ajoutée avec succès ! <a href="../?section=add-notifications">Retour</a>';
        exit;
    } else {
        echo 'Erreur lors de l\'ajout de la notification. <a href="../?section=add-notifications">Retour</a>';
        exit;
    }
} else {
    echo 'Erreur : contenu de la notification non fourni. <a href="../?section=add-notifications">Retour</a>';
    exit;
}

