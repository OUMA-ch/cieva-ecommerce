<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once __DIR__ . '/includes/head.php' ?>
    <title>Inscription</title>
    <link rel="stylesheet" href="/src/css/inscription.css">
</head>

<body>
    <?php include_once __DIR__ . '/includes/header.php' ?>
    <main>
        <div class="form-container">
            <div class="img-container">
                <img class="logo" src="/assets/images/logos/logo-removebg-preview.png" alt="">
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <!-- Informations de connexion -->
                <div class="info-container">
                    <h2>Informations de connexion :</h2>
                    <div class="input-container">
                        <label for="email">E-mail : <span>*</span></label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="input-container">
                        <label for="password">Mot de passe : <span>*</span></label>
                        <input type="password" name="password" id="password" required>
                        <div class="info-message">
                            <i class="fa-regular fa-circle-question"></i>
                            Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et
                            un caractère spécial.
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="confirm_password">Confirmer le mot de passe : <span>*</span></label>
                        <input type="password" name="confirm_password" id="confirm_password"
                            placeholder="Confirmez votre mot de passe" required>
                    </div>
                </div>
                <!-- Informations personnelles -->
                <div class="info-container">
                    <h2>Informations personnelles :</h2>
                    <div class="input-container">
                        <label for="img-profile">Image du  profile :</label>
                        <input type="file" accept="images/*" name="img-profile" id="img-profile" required>
                        <div class="img-container" onClick="document.getElementById('img-profile').click();">
                            <img src="/assets/images/profiles/woman-7531315_1280.png" alt="Image du profile" id="img-profile-review">
                            <script>
                                // Afficher l'image sélectionnée dans le champ de prévisualisation
                                document.getElementById('img-profile').addEventListener('change', function() {
                                    var file = this.files[0];
                                    var reader = new FileReader();
                                    reader.onload = function(event) {
                                        document.getElementById('img-profile-review').src = event.target.result;
                                    };
                                    reader.readAsDataURL(file);
                                });
                            </script>
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="last_name">Nom de famille : <span>*</span></label>
                        <input type="text" name="last_name" id="last_name" placeholder="Entrez votre nom de famille"
                            required>
                    </div>
                    <div class="input-container">
                        <label for="first_name">Prénom : <span>*</span></label>
                        <input type="text" name="first_name" id="first_name" placeholder="Entrez votre prénom" required>
                    </div>
                </div>
                <!-- Informations d'adresse -->
                <div class="info-container">
                    <h2>Informations d'adresse :</h2>
                    <div class="input-container">
                        <label for="full_address">Adresse complète : <span>*</span></label>
                        <input type="text" name="full_address" id="full_address"
                            placeholder="Adresse complète (rue, bâtiment, appartement, etc.)." required>
                    </div>
                    <div class="input-container">
                        <label for="city">Ville : <span>*</span></label>
                        <input type="text" name="city" id="city" placeholder="Entrez votre ville" required>
                    </div>
                    <div class="input-container">
                        <label for="postal_code">Code postal : <span>*</span></label>
                        <input type="text" id="postal_code" name="postal_code" placeholder="Entrez votre code postal"
                            required>
                    </div>
                    <div>
                        <label for="country">Pays : <span>*</span></label>
                        <select name="country" id="country" required>
                            <option value="" disabled>Sélectionnez votre pays</option>
                            <option value="Algeria" disabled>Algérie</option>
                            <option value="Egypt" disabled>Égypte</option>
                            <option value="Morocco" selected>Maroc</option>
                            <option value="Saudi Arabia" disabled>Arabie Saoudite</option>
                            <option value="Tunisia" disabled>Tunisie</option>
                        </select>
                    </div>
                    <!-- Contact -->
                    <div>
                        <h2>Contact</h2>
                        <div class="input-container">
                            <label for="phone"></label>
                            <input type="number" name="phone" id="phone" minlength="10" maxlength="10"
                                placeholder="Numéro de téléphone: ex : 0612345678">
                            <div class="info-message">
                                <i class="fa-regular fa-circle-question"></i>
                                Veuillez entrer un numéro de téléphone marocain valide, composé de 10 chiffres et commençant par 06, 07, ou 05.
                            </div>
                        </div>
                    </div>

                    <!-- btns -->
                    <div>
                        <button type="submit">S'inscrire</button>
                        <button type="reset">Annuler</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <?php include_once __DIR__ . '/includes/footer.php' ?>

    <script src="/src/js/animation-input.js"></script>
</body>

</html>