<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// verifier si l'utilisateur est connecté
$user = $_SESSION['user'];
if (!isset($user)) {
    header('Location: connexion.php');
    exit;
}


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once __DIR__ . '/includes/head.php' ?>
    <title>Profile</title>
</head>

<body>
    <?php include_once __DIR__ . '/includes/header.php' ?>
    <main>
        <h1>Profile de l'utilisateur</h1>
        <p>Nom: <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></p>
        <p>Email: <?= htmlspecialchars($user['email']) ?></p>
        <p>Numéro de téléphone: <?= htmlspecialchars($user['numero_telephone']) ?></p>
    </main>
    <?php include_once __DIR__ . '/includes/footer.php' ?>
</body>

</html>
