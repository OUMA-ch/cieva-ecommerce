<?php
// recuperation des donnees de marque
$nom = trim($_POST['name']);
$logo = $_FILES['logo'];
$description = trim($_POST['description']);

// tableux des errors
$errors = [];

// verification des informations
if (empty($nom) || !preg_match('/^[a-zA-Z0-9_]+$/', $nom)) {
    $errors[] = "Le nom de la marque est obligatoire et doit contenir des lettres, chiffres ou underscore";
}

if (empty($description) || strlen($description) < 10) {
    $errors[] = "La description est obligatoire et doit contenir au moins 10 caracteres";
}

$image_types = [
    'image/jpeg', 'image/png','image/gif',
    'image/jpg', 'image/svg'
];
if (empty($logo['name']) || !in_array($logo['type'], $image_types)) {
    $errors[] = "Le logo est obligatoire et doit etre un fichier image (jpeg, png, gif, jpg, svg)";
}


// verfifcation si il a y des errors
if(count($errors) > 0) {
    foreach($errors as $error) {
        echo "$error<br>";
    }
    exit;
}

include_once '../../../database/utils/showErrors.php';


// enregistrer la marque
// enregistrer le logo dans dossier des marques et prende son url
$dir = __DIR__ . "/../../../assets/images/marques/";
$unique_id = uniqid();
$logo_url = "/assets/images/marques/" . $unique_id . "-" . $logo['name'];
move_uploaded_file($logo['tmp_name'], $dir . $unique_id . "-" . $logo['name']);

include_once '../../../database/utils/set.php';
$sql = "INSERT INTO marques (nom, description, logo_url) VALUES (:nom, :description, :logo_url)";
$params = [
    'nom' => $nom,
    'description' => $description,
    'logo_url' => $logo_url
];

if(set($sql, $params)) {
    echo "La marque a ete ajoutee avec succes ! <a href=\"../?section=add-brand\">Retour</a>";
} else {
    echo "Erreur lors de l'ajout de la marque. Veuillez reessayer ! <a href=\"../?section=add-brand\">Retour</a>";
}
