CREATE DATABASE IF NOT EXISTS biblio_db;
USE biblio_db;

-- Table des utilisateurs
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('standard', 'admin') NOT NULL DEFAULT 'standard'
);

-- Table des livres
CREATE TABLE livres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(255) NOT NULL,
    genre VARCHAR(100) NOT NULL,
    statut ENUM('disponible', 'emprunté') NOT NULL DEFAULT 'disponible'
);

-- Table des emprunts
CREATE TABLE emprunts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_livre INT NOT NULL,
    date_emprunt DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_retour DATETIME NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (id_livre) REFERENCES livres(id) ON DELETE CASCADE
);

-- Création d'un utilisateur administrateur par défaut
INSERT INTO utilisateurs (nom, email, mot_de_passe, role) 
VALUES ('Admin', 'admin@biblio.com', SHA2('admin123', 256), 'admin');
