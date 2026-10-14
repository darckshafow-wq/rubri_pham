-- ==========================================================================
-- phama_garde - Schéma de la base de données & Données de test
-- Architecture MVC PHP Pur (Côte d'Ivoire)
-- ==========================================================================

CREATE DATABASE IF NOT EXISTS phama_garde
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE phama_garde;

SET FOREIGN_KEY_CHECKS = 0;

-- Suppression des anciennes tables si existantes
DROP TABLE IF EXISTS guard_schedules;
DROP TABLE IF EXISTS neighborhoods;
DROP TABLE IF EXISTS cities;
DROP TABLE IF EXISTS pharmacies;
DROP TABLE IF EXISTS users;

SET FOREIGN_KEY_CHECKS = 1;

-- ==========================================================================
-- Table users
-- ==========================================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'pharmacy') NOT NULL DEFAULT 'pharmacy',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================================================
-- Table pharmacies
-- ==========================================================================
CREATE TABLE pharmacies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    city VARCHAR(100) NOT NULL,
    neighborhood VARCHAR(100) DEFAULT NULL,
    address TEXT,
    phone VARCHAR(20),
    is_on_guard TINYINT(1) NOT NULL DEFAULT 0,
    is_approved TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================================================
-- Données initiales : Utilisateurs (Mot de passe pour tous les tests : 'admin')
-- Hachage bcrypt de 'admin' : $2y$12$Pb2bV.TZ8NRXCZywQ6J6XesViaPW6aZANQBzzHyQQ.ngzcc5doeey
-- ==========================================================================
INSERT INTO users (id, name, email, password, role) VALUES
    (1, 'Super Admin', 'admin@admin.com', '$2y$12$Pb2bV.TZ8NRXCZywQ6J6XesViaPW6aZANQBzzHyQQ.ngzcc5doeey', 'admin'),
    (2, 'Dr. Koffi Yao', 'dr.koffi@phamagarde.ci', '$2y$12$Pb2bV.TZ8NRXCZywQ6J6XesViaPW6aZANQBzzHyQQ.ngzcc5doeey', 'pharmacy'),
    (3, 'Dr. Aminata Diallo', 'dr.aminata@phamagarde.ci', '$2y$12$Pb2bV.TZ8NRXCZywQ6J6XesViaPW6aZANQBzzHyQQ.ngzcc5doeey', 'pharmacy'),
    (4, 'Dr. Kouassi Jean', 'dr.kouassi@phamagarde.ci', '$2y$12$Pb2bV.TZ8NRXCZywQ6J6XesViaPW6aZANQBzzHyQQ.ngzcc5doeey', 'pharmacy'),
    (5, 'Dr. Bamba Seydou', 'dr.seydou@phamagarde.ci', '$2y$12$Pb2bV.TZ8NRXCZywQ6J6XesViaPW6aZANQBzzHyQQ.ngzcc5doeey', 'pharmacy'),
    (6, 'Dr. Traoré Fatou', 'dr.fatou@phamagarde.ci', '$2y$12$Pb2bV.TZ8NRXCZywQ6J6XesViaPW6aZANQBzzHyQQ.ngzcc5doeey', 'pharmacy'),
    (7, 'Dr. Konan Michel', 'dr.konan@phamagarde.ci', '$2y$12$Pb2bV.TZ8NRXCZywQ6J6XesViaPW6aZANQBzzHyQQ.ngzcc5doeey', 'pharmacy');

-- ==========================================================================
-- Données initiales : Pharmacies de test (Côte d'Ivoire)
-- ==========================================================================
INSERT INTO pharmacies (id, user_id, name, city, neighborhood, address, phone, is_on_guard, is_approved) VALUES
    -- 1. Yamoussoukro (Approuvée & De garde)
    (1, 2, 'Pharmacie du Bélier', 'Yamoussoukro', 'Morofe', 'En face de la grande mosquée', '+225 07 01 02 03 04', 1, 1),

    -- 2. Abidjan Cocody (Approuvée & De garde)
    (2, 3, 'Grande Pharmacie des Cocotiers', 'Abidjan', 'Cocody', 'Boulevard de France, carrefour la vie', '+225 05 11 22 33 44', 1, 1),

    -- 3. Abidjan Plateau (Approuvée & Hors garde)
    (3, 4, 'Pharmacie du Plateau', 'Abidjan', 'Plateau', 'Avenue Chardy, près de la poste', '+225 07 44 55 66 77', 0, 1),

    -- 4. Abidjan Yopougon (Approuvée & De garde)
    (4, 5, 'Pharmacie Saint Joseph', 'Abidjan', 'Yopougon', 'Carrefour Siporex, route de Dabou', '+225 01 88 99 00 11', 1, 1),

    -- 5. Bouaké (Approuvée & Hors garde)
    (5, 6, 'Pharmacie de la Paix', 'Bouaké', 'Commerce', 'Près du grand marché de Bouaké', '+225 05 66 77 88 99', 0, 1),

    -- 6. En attente de validation (pour tester l'interface admin !)
    (6, 7, 'Pharmacie Espoir Marcory', 'Abidjan', 'Marcory', 'Boulevard de Lorraine, face station Shell', '+225 07 99 88 77 66', 0, 0);
