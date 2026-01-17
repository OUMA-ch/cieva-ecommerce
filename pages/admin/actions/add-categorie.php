<?php

include_once __DIR__ . '/../../../database/utils/set.php';
include_once __DIR__ . '/../../../database/utils/showErrors.php';

if (!empty($_POST)) {
    $nom = trim($_POST['nom']);
    $description = trim($_POST['description']);
    $errors = [];

    if (empty($nom) || !preg_match('/^[A-Za-z0-9_ ]+$/', $nom)) {
        $errors[] = "Le nom de la catégorie est obligatoire et ne peut contenir que des lettres, des chiffres, des underscores et des espaces.";
    }

    if (empty($description) || strlen($description) < 10) {
        $errors[] = "La description est obligatoire et doit contenir au moins 10 caractères.";
    }

    $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    if (!empty($_FILES['image_url']['name']) && !in_array($_FILES['image_url']['type'], $allowed_image_types)) {
        $errors[] = "L'image doit être un fichier de type (jpeg, png, gif, jpg).";
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "$error<br>";
        }
        exit;
    }

    $dir = __DIR__ . '/../../../assets/images/categories/';
    $image_url = $_FILES['image_url']['name'] ? '/assets/images/categories/' . uniqid() . '-' . $_FILES['image_url']['name'] : null;
    if ($image_url) {
        move_uploaded_file($_FILES['image_url']['tmp_name'], $dir . basename($image_url));
    }

    $params = [
        'nom' => $nom,
        'description' => $description,
        'image_url' => $image_url
    ];

    if (set('INSERT INTO categories (nom, description, image_url) VALUES (:nom, :description, :image_url)', $params)) {
        echo "La catégorie a été ajoutée avec succès ! <a href=\"../?section=add-categorie\">Retour</a>";
    } else {
        echo "Erreur lors de l'ajout de la catégorie. Veuillez réessayer !";
    }
}

