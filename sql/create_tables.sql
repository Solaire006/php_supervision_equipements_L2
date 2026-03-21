-- script pour créer les tables de la base de données
CREATE TABLE IF NOT EXISTS supervision_db;
USE supervision_db;

CREATE TABLE IF NOT EXISTS equipements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    adresse_ip VARCHAR(15) NOT NULL,
    type ENUM('routeur', 'serveur', 'commutateur') NOT NULL,
    date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP
);