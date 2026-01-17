<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'];

include_once __DIR__ . '/../../database/utils/getAll.php';

// les termes de recherche

$temres_recherche = getAll("SELECT DISTINCT termes FROM terme_recherche LIMIT 10");
$termes = array_column($temres_recherche, 'termes');

// notifications
$notifications = getAll("SELECT * FROM notifications WHERE DATE(date_creation) = CURDATE()");

$panier = [];
$produits_preferes = [];
if (isset($user)) {
    // panier
    $panier = getAll("SELECT * FROM panier WHERE id_utilisateur = :id_utilisateur", ['id_utilisateur' => $user['id']]);

    // produits preferes
    $produits_preferes = getAll("SELECT * FROM produits_preferes WHERE id_utilisateur = :id_utilisateur", ['id_utilisateur' => $user['id']]);
}

?>
<header>
    <div class="part-1">
        <a href="https://www.facebook.com" target="_blank">
            <i class="fa-brands fa-facebook"></i>
        </a>
        <a href="https://www.instagram.com" target="_blank">
            <i class="fa-brands fa-instagram"></i>
        </a>
        <a href="https://www.twitter.com" target="_blank">
            <i class="fa-brands fa-twitter"></i>
        </a>
        <a href="https://www.linkedin.com" target="_blank">
            <i class="fa-brands fa-linkedin"></i>
        </a>
        <a href="https://www.youtube.com" target="_blank">
            <i class="fa-brands fa-youtube"></i>
        </a>
        <a href="https://www.pinterest.com" target="_blank">
            <i class="fa-brands fa-pinterest"></i>
        </a>
        <div>|</div>
        <a href="tel:+212600000000" target="_blank">
            +212 612345678
        </a>
    </div>
    <div class="part-2">
        <a class="logo" href="/index.php">
            <img src="/assets/images/logos/logo-removebg-preview.png" alt="" width="100">
        </a>
        <ul class="menu">
            <li><a href="/index.php"> <i class="fa-solid fa-house"></i> Home</a></li>
            <li>
                <a href="/pages/produits.php"> <i class="fa-solid fa-boxes-stacked"></i> Produits</a>
            </li>
            <li><a href="/pages/about-us.php"></a></li>
            <?php if (isset($user)): ?>
                <li><a href="/pages/profileUtilisateur.php"> <i class="fa-solid fa-user"></i> Profil</a></li>
                <li><a href="/pages/deconnecter.php"> <i class="fa-solid fa-arrow-right-from-bracket"></i> Deconnecter</a></li>
                <?php if ($user['est_admin'] === 1) : ?>
                    <li><a href="/pages/admin/"> <i class="fa-solid fa-lock"></i> Admin</a></li>
                <?php endif; ?>
            <?php else : ?>
                <li><a href="/pages/connexion.php"> <i class="fa-solid fa-lock"></i> Connexion</a></li>
                <li><a href="/pages/inscription.php"> <i class="fa-solid fa-user-plus"></i> Inscription</a></li>
            <?php endif; ?>
        </ul>
        <div class="search-container" id="search-container">
            <div class="content">
                <form action="/pages/search.php" method="get">
                    <input type="search" name="search" id="search" placeholder="" maxlength="255" required>
                    <button type="submit" title="Rechercher">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <script>
                        let searchInput = document.getElementById('search');
                        let placeholderTexts = [
                            "Rechercher des produits ici...",
                            <?php foreach ($termes as $term) : ?> "<?php echo $term; ?>",
                            <?php endforeach; ?>
                        ];

                        let textIndex = 0;
                        let letterIndex = 0;
                        let timer = null;

                        function typePlaceholder() {
                            const phrase = placeholderTexts[textIndex];
                            if (letterIndex < phrase.length) {
                                // Ajoute une lettre au placeholder
                                searchInput.placeholder += phrase[letterIndex];
                                letterIndex++;
                            } else {
                                // Attendre 2 secondes avant de passer à la phrase suivante
                                clearTimeout(timer);
                                timer = setTimeout(() => {
                                    textIndex = (textIndex + 1) % placeholderTexts.length;
                                    searchInput.placeholder = ''; // Réinitialise le placeholder
                                    letterIndex = 0; // Réinitialise l'index des lettres
                                    typePlaceholder(); // Recommence pour la nouvelle phrase
                                }, 2000);
                                return;
                            }

                            // Continue la frappe
                            setTimeout(typePlaceholder, 100);
                        }

                        // Lance la frappe initiale
                        typePlaceholder();


                        const searchContainer = document.getElementById('search-container');
                        searchInput.addEventListener('input', () => {
                            if (searchInput.value.trim() !== "") {
                                searchContainer.classList.add("active");
                            } else {
                                searchContainer.classList.remove("active");
                            }
                        });
                    </script>
                </form>
                <div class="options">
                    <ul id="options-list"></ul>
                    <script>
                        const input = document.getElementById('search');
                        input.addEventListener('input', async () => {
                            const options = await getOptions(input.value);
                            const list = document.getElementById('options-list');
                            list.innerHTML = '';
                            if (options.length === 0) {
                                const li = document.createElement('li');
                                li.innerHTML = 'Aucun resultat';
                                list.appendChild(li);
                            } else {
                                options.forEach(option => {
                                    const li = document.createElement('li');
                                    li.innerHTML = `<a href="/pages/search.php?search=${option.nom}"><i class="fa-solid fa-magnifying-glass"></i> ${option.nom}</a>`;
                                    list.appendChild(li);
                                });
                            }
                        });

                        async function getOptions(term) {
                            const response = await fetch('/database/api/search-items-options.php?term=' + term);
                            const data = await response.json();
                            return data.products;
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="icons">
        <a class="icon profile" href="/pages/profileUtilisateur.php" title="Profile">
            <img src="<?php echo $user['profile_image_url'] ?: '/assets/images/profiles/default.png'; ?>" width="50">
            <div class="info">
                <?php if (isset($user)): ?>
                    <h4><?php echo $user['prenom'] . ' ' . $user['nom']; ?></h4>
                    <p><?php echo $user['email']; ?></p>
                <?php else : ?>
                    <p>Vous devez vous connecter</p>
                <?php endif; ?>
            </div>
        </a>
        <a class="icon" href="/pages/notifications.php" title="Notifications">
            <span><?php echo count($notifications); ?></span>
            <i class="fa-solid fa-bell"></i>
        </a>
        <a class="icon" href="/pages/panier.php" title="Panier">
            <span><?php echo count($panier); ?></span>
            <i class="fa-solid fa-cart-shopping"></i>
        </a>
        <a class="icon" href="product-prefered.php" title="Produits préférés">
            <i class="fa-solid fa-heart"></i>
            <span><?php echo count($produits_preferes); ?></span>
        </a>
        <a class="icon" href="#" title="Retour en haut" onclick="scrollToTop()">
            <i class="fa-solid fa-arrow-up"></i>
        </a>
    </div>
</header>