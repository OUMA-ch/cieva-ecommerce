<footer>
    <div class="footer-container">
        <!-- Logo -->
        <div class="footer-logo">
            <img src="/assets/images/logos/logo-removebg-preview.png" alt="Logo de l'entreprise" width="100">
        </div>

        <!-- Bloc 1 : Informations -->
        <div class="footer-links">
            <h4>Informations</h4>
            <ul>
                <li><a href="/pages/about-us.php">À propos de nous</a></li>
                <li><a href="/pages/terms.php">Conditions générales</a></li>
                <li><a href="/pages/privacy.php">Politique de confidentialité</a></li>
                <li><a href="/pages/mentions-legales.php">Mentions légales</a></li>
            </ul>
        </div>

        <!-- Bloc 2 : Assistance -->
        <div class="footer-links">
            <h4>Assistance</h4>
            <ul>
                <li><a href="/pages/contact.php">Nous contacter</a></li>
                <li><a href="/pages/faqs.php">FAQs</a></li>
                <li><a href="/pages/support.php">Support client</a></li>
                <li><a href="/pages/returns.php">Retours et remboursements</a></li>
            </ul>
        </div>

        <!-- Bloc 3 : Suivez-nous -->
        <div class="footer-links">
            <h4>Suivez-nous</h4>
            <ul>
                <li><a href="https://facebook.com" target="_blank"><i class="fa-brands fa-facebook"></i> Facebook</a></li>
                <li><a href="https://twitter.com" target="_blank"><i class="fa-brands fa-twitter"></i> Twitter</a></li>
                <li><a href="https://instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i> Instagram</a></li>
                <li><a href="https://linkedin.com" target="_blank"><i class="fa-brands fa-linkedin"></i> LinkedIn</a></li>
            </ul>
        </div>

        <!-- Bloc Newsletter -->
        <div class="footer-form">
            <h4>Inscrivez-vous à notre newsletter</h4>
            <form action="/pages/newsletter.php" method="post">
                <div class="form-group">
                    <label for="first_name">Prénom :</label>
                    <input type="text" name="first_name" id="first_name" placeholder="Votre prénom" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Nom :</label>
                    <input type="text" name="last_name" id="last_name" placeholder="Votre nom" required>
                </div>
                <div class="form-group">
                    <label for="email">Adresse e-mail :</label>
                    <input type="email" name="email" id="email" placeholder="votre.email@example.com" required>
                </div>
                <button type="submit" class="subscribe-button">S'inscrire</button>
            </form>
        </div>
    </div>
    <!-- Pied de page -->
    <div class="footer-bottom">
        <p>&copy; 2024 Nom de l'entreprise. Tous droits réservés.</p>
    </div>
</footer>