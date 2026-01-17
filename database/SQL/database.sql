CREATE DATABASE IF NOT EXISTS `cieva_db`;
USE `cieva_db`;

CREATE TABLE `produits` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `prix` double NOT NULL,
  `ancien_prix` double NOT NULL,
  `nom` varchar(20) NOT NULL,
  `description` text,
  `stock` int,
  `id_marque` int,
  `date_creation` DATETIME NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `images_produit` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `img_url` varchar(255),
  `id_produit` int,
  `date_creation` DATETIME NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `marques` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `description` text,
  `logo_url` varchar(255),
  `date_creation` DATETIME NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `produits_categories` (
  `id_produit` int NOT NULL,
  `id_categorie` int NOT NULL
);

CREATE TABLE `categories` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `image_url` VARCHAR(255) DEFAULT '/assets/images/categories/default.png',
  `description` text,
  `date_creation` DATETIME NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `utilisateurs` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `numero_telephone` varchar(10) UNIQUE NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL,
  `est_admin` boolean DEFAULT 0,
  `profile_image_url` varchar(255) DEFAULT '/assets/images/profiles/default.png',
  `ville` varchar(20),
  `code_postale` int,
  `pays` varchar(20) NOT NULL,
  `date_creation` DATETIME NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `panier` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_produit` int,
  `id_utilisateur` int,
  `quantite` int NOT NULL DEFAULT 1,
  `date_creation` DATETIME NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `produits_preferes` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_produit` int,
  `id_utilisateur` int,
  `date_creation` DATETIME NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `commandes` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `id_utilisateur` INT NOT NULL,
  `id_details_commande` INT NOT NULL,
  `statut` VARCHAR(50) DEFAULT 'en_attente',
  `date_creation` DATETIME NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `details_commande` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_produit` int NOT NULL,
  `quantite_produit` int NOT NULL,
  `date_creation` DATETIME NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `paiement` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_commande` int,
  `id_utilisateur` int,
  `type_paiement` varchar(50) NOT NULL,
  `date_creation` DATETIME NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `terme_recherche` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `termes` varchar(255) NOT NULL,
  `date_creation` DATETIME NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `newsletter` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nom` varchar(120) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `date_creation` DATETIME NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `commentaires` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `id_produit` int NOT NULL,
  `note` int DEFAULT 5,
  `date_creation` DATETIME NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `notifications` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `content` text NOT NULL,
  `date_creation` DATETIME NOT NULL DEFAULT current_timestamp
);

ALTER TABLE `produits` ADD FOREIGN KEY (`id_marque`) REFERENCES `marques` (`id`);

ALTER TABLE `images_produit` ADD FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`);

ALTER TABLE `produits_categories` ADD FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`);

ALTER TABLE `produits_categories` ADD FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id`);

ALTER TABLE `panier` ADD FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`);

ALTER TABLE `panier` ADD FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`);

ALTER TABLE `produits_preferes` ADD FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`);

ALTER TABLE `produits_preferes` ADD FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`);

ALTER TABLE `commandes` ADD FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`);

ALTER TABLE `commandes` ADD FOREIGN KEY (`id_details_commande`) REFERENCES `details_commande` (`id`);

ALTER TABLE `details_commande` ADD FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`);

ALTER TABLE `paiement` ADD FOREIGN KEY (`id_commande`) REFERENCES `commandes` (`id`);

ALTER TABLE `paiement` ADD FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`);

ALTER TABLE `commentaires` ADD FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`);

ALTER TABLE `commentaires` ADD FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`);

-- Ajout des deux administrateurs
INSERT INTO utilisateurs (nom, prenom, numero_telephone, email, password, est_admin, pays) VALUES
('Chihab', 'Oumaima', '1234567890', 'oumaima@cieva.com', 'Oumaima@123', 1, 'Maroc'),
('Echarkaouy', 'Ayyoub', '1234567891', 'echarkaouy@cieva.com', 'Ayyoub@123', 1, 'Maroc');

