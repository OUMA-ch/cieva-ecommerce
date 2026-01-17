<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once __DIR__ . '/../includes/head.php' ?>
    <title>Newsletter</title>
</head>

<body>
    <?php include_once __DIR__ . '/pages/includes/header.php' ?>
    <main>
        <?php
        include_once __DIR__ . '/../database/utils/get.php';
        include_once __DIR__ . '/../database/utils/set.php';
        if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'])) {
            $prenom = htmlspecialchars($_POST['first_name']);
            $nom = htmlspecialchars($_POST['last_name']);
            $email = htmlspecialchars($_POST['email']);

            $errors = [];
            if (empty($prenom) || !preg_match('/^[A-Za-z]+$/', $prenom)) {
                $errors[] = "Le prénom est obligatoire et ne peut contenir que des lettres.";
            }

            if (empty($nom) || !preg_match('/^[A-Za-z]+$/', $nom)) {
                $errors[] = "Le nom est obligatoire et ne peut contenir que des lettres.";
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'adresse e-mail est obligatoire et est invalide.";
            }

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<p class='error-message'>$error</p>";
                }
            } else {
                if (get("SELECT * FROM newsletter WHERE email = :email", [
                    'email' => $email
                ])) {
                    echo "<p class='error-message'>Vous êtes déjà inscrit à notre newsletter ! <a href='javascript:history.back()'>Retour</a></p>";
                } else if (set("INSERT INTO newsletter (nom, prenom, email) VALUES (:nom, :prenom, :email)", [
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email
                ])) {
                    echo "<p class='success-message'>Vous êtes maintenant inscrit à notre newsletter ! <a href='javascript:history.back()'>Retour</a></p>";
                } else {
                    echo "<p class='error-message'>Une erreur est survenue lors de l'inscription. <a href='javascript:history.back()'>Retour</a></p>";
                }
            }
        }
        ?>
    </main>
    <?php include_once __DIR__ . '/pages/includes/footer.php' ?>
</body>

</html>