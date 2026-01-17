<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'];
// verifier si l'utilisateur est connecté
if (!isset($user)) {
    header('Location: ../connexion.php');
    exit;
}

// verifier si l'utilisateur est admin
if (!$user['est_admin']) {
    header('Location: profileUtilisateur.php');
    exit;
}
if (isset($_GET['section'])) {
    $section = $_GET['section'];
} else {
    $section = 'welcome';
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once __DIR__ . '/../includes/head.php' ?>
    <title>Admin - <?= htmlspecialchars($section) ?></title>
    <link rel="stylesheet" href="/src/css/admin.css" type="text/css">
</head>

<body>
    <div class="container">
        <header>
            <a class="profile" href="/pages/profileUtilisateur.php">
                <div class="img-container">
                    <img src="<?php echo $user['profile_image_url'] ?>" alt="" width="50">
                </div>
                <div class="profile-info">
                    <p class="name"><?= $user['prenom'] . ' ' . $user['nom'] ?></p>
                    <p class="email"><?= $user['email'] ?></p>
                </div>
            </a>
            <nav>
                <ul>
                    <li><a href="?section=add-product"><i class="fa-solid fa-box-open"></i> Ajouter un produit</a></li>
                    <li><a href="?section=list-products"><i class="fa-solid fa-list"></i> Liste des produits</a></li>

                    <li><a href="?section=add-brand"><i class="fa-solid fa-crown"></i> Ajouter une marque</a></li>
                    <li><a href="?section=list-brands"><i class="fa-solid fa-list"></i> Liste des marques</a></li>

                    <li><a href="?section=add-categorie"><i class="fa-solid fa-tag"></i> Ajouter une categorie</a></li>
                    <li><a href="?section=list-categorie"><i class="fa-solid fa-list"></i> Liste des categorie</a></li>

                    <li><a href="?section=list-newsletter"><i class="fa-solid fa-envelope"></i> Liste des newsletters</a></li>

                    <li><a href="?section=statistics"><i class="fa-solid fa-chart-column"></i> Statistiques</a></li>

                    <li><a href="?section=add-notifications"><i class="fa-solid fa-bell"></i> Ajouter une notification</a></li>

                    <li><a href="?section=list-orders"><i class="fa-solid fa-list"></i> Liste des commandes</a></li>
                    <li><a href="../deconnecter.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Deconnecter</a></li>
                </ul>
            </nav>
        </header>
        <div class="content-container">
            <div class="content">
                <!-- Les sections -->
                <?php include_once "sections/$section.php"; ?>
            </div>
            <footer>
                <p>&copy; 2024 Tous droits réservés</p>
            </footer>
        </div>
    </div>
</body>

</html>