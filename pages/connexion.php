<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../database/utils/get.php';


$errors = [];

// Vérifications
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification de l'email ou du numéro de téléphone
    if (empty($_POST['phone_or_email'])) {
        $errors[] = "Veuillez entrer une adresse e-mail ou un numéro de téléphone.";
    } else {
        $phone_or_email = trim($_POST['phone_or_email']);

        // Vérification du type de saisie (email ou numéro de téléphone)
        $isEmail = false;
        $phone_pattern = '/^(06|07|05)[0-9]{8}$/';
        $email_pattern = '/^[\w.%+-]+@[\w.-]+\.[a-zA-Z]{2,}$/';

        if (preg_match($phone_pattern, $phone_or_email)) {
            $isEmail = false; // C'est un numéro de téléphone
        } elseif (preg_match($email_pattern, $phone_or_email)) {
            $isEmail = true; // C'est une adresse e-mail
        } else {
            $errors[] = "La saisie n'est ni un numéro de téléphone valide ni une adresse e-mail valide.";
        }
    }

    // Vérification du mot de passe
    if (!empty($_POST['password'])) {
        $password = trim($_POST['password']);
        if (strlen($password) < 8) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Le mot de passe doit contenir au moins une lettre majuscule.";
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Le mot de passe doit contenir au moins une lettre minuscule.";
        }
        if (!preg_match('/\d/', $password)) {
            $errors[] = "Le mot de passe doit contenir au moins un chiffre.";
        }
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors[] = "Le mot de passe doit contenir au moins un caractère spécial.";
        }
    } else {
        $errors[] = "Le mot de passe est requis.";
    }

    // Si aucune erreur, vérification dans la base de données
    if (empty($errors)) {

        $user_name = $isEmail ? 'email' : 'numero_telephone';
        $sql = "SELECT * FROM utilisateurs WHERE $user_name = :phone_or_email AND password = :password";
        $params = [
            'phone_or_email' => $phone_or_email,
            'password' => $password
        ];

        $utilisateur = get($sql, $params);
        if ($utilisateur) {
            // Stockage de l'utilisateur dans la session
            $_SESSION['user'] = $utilisateur;
            // Vérification du rôle de l'utilisateur
            if ($utilisateur['est_admin']) {
                header('Location: admin/index.php');
                exit;
            } else {
                header('Location: profileUtilisateur.php');
                exit;
            }
        } else {
            $errors[] = ($isEmail ? "Adresse e-mail" : "Numéro de téléphone") . " ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once __DIR__ . '/includes/head.php'; ?>
    <link rel="stylesheet" href="/src/css/connexion.css">
    <title>Connexion</title>
</head>

<body>
    <?php include_once __DIR__ . '/includes/header.php'; ?>
    <main>
        <div class="form-container">
            <div class="img-container">
                <img class="logo" src="/assets/images/logos/logo-removebg-preview.png" alt="Logo">
            </div>
            <form action="" method="post">
                <div class="errors-container">
                    <?php if (!empty($errors)): ?>
                        <ul class="errors">
                            <?php foreach ($errors as $error): ?>
                                <li class="error"><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="input-container">
                    <label for="phone_or_email">E-mail ou numéro de tél : <span>*</span></label>
                    <input type="text" name="phone_or_email" id="phone_or_email"
                        placeholder="Adresse e-mail ou numéro de téléphone" required>
                </div>
                <div class="input-container">
                    <label for="password">Mot de passe : <span>*</span></label>
                    <input type="password" name="password" id="password" minlength="8"
                        placeholder="Entrez votre mot de passe" required>
                    <div class="info-message">
                        <i class="fa-regular fa-circle-question"></i>
                        Votre mot de passe doit contenir au moins :
                        <ul>
                            <li>8 caractères</li>
                            <li>1 lettre majuscule</li>
                            <li>1 lettre minuscule</li>
                            <li>1 chiffre</li>
                            <li>1 caractère spécial (par exemple : @, #, $)</li>
                        </ul>
                    </div>
                </div>
                <button class="confirmer" name="confirmer" type="submit">Confirmer</button>
                <div class="links">
                    <a href="/pages/inscription.php" target="_blank"><i class="fa-solid fa-up-right-from-square"></i> Vous n'avez pas un compte ?</a>
                    <a href="/pages/reset-password.php" target="_blank"><i class="fa-solid fa-up-right-from-square"></i> Mot de passe oublié ?</a>
                </div>
            </form>
        </div>
    </main>
    <?php include_once __DIR__ . '/includes/footer.php'; ?>
    <script src="/src/js/animation-input.js"></script>
</body>

</html>