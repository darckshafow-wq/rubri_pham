<?php
require_once __DIR__ . '/Database.php';

/**
 * Modèle User - Gestion des comptes utilisateurs
 */
class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /** Rechercher un utilisateur par email */
    public function findByEmail(string $email): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    /** Rechercher un utilisateur par ID */
    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /** Créer un nouvel utilisateur (mot de passe haché automatiquement) */
    public function create(array $data): int|false
    {
        $stmt = $this->db->prepare(
            'INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)'
        );
        $result = $stmt->execute([
            ':name'     => $data['name'],
            ':email'    => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':role'     => $data['role'] ?? 'pharmacy',
        ]);
        return $result ? (int) $this->db->lastInsertId() : false;
    }

    /** Récupérer tous les utilisateurs */
    public function getAll(): array
    {
        return $this->db->query('SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC')->fetchAll();
    }
}

