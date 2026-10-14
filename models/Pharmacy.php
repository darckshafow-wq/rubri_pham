<?php
require_once __DIR__ . '/Database.php';

/**
 * Modèle Pharmacy - Gestion des pharmacies partenaires
 */
class Pharmacy
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /** Récupérer toutes les pharmacies */
    public function getAll(): array
    {
        return $this->db->query('SELECT * FROM pharmacies ORDER BY name ASC')->fetchAll();
    }

    /** Rechercher une pharmacie par ID */
    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM pharmacies WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /** Rechercher la pharmacie liée à un user_id */
    public function findByUserId(int $userId): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM pharmacies WHERE user_id = :uid LIMIT 1');
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetch();
    }

    /**
     * Recherche filtrée par ville, quartier, nom
     * Ne retourne que les pharmacies approuvées (is_approved = 1)
     * Triées par statut de garde en priorité
     */
    public function search(?string $city = null, ?string $neighborhood = null, ?string $name = null): array
    {
        $sql = "SELECT * FROM pharmacies WHERE is_approved = 1";
        $params = [];

        if (!empty($city)) {
            $sql .= ' AND city = :city';
            $params[':city'] = $city;
        }
        if (!empty($neighborhood)) {
            $sql .= ' AND neighborhood LIKE :neighborhood';
            $params[':neighborhood'] = '%' . $neighborhood . '%';
        }
        if (!empty($name)) {
            $sql .= ' AND name LIKE :name';
            $params[':name'] = '%' . $name . '%';
        }

        $sql .= ' ORDER BY is_on_guard DESC, name ASC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /** Récupérer toutes les pharmacies de garde (approuvées) */
    public function getOnGuard(): array
    {
        return $this->db->query(
            "SELECT * FROM pharmacies WHERE is_on_guard = 1 AND is_approved = 1 ORDER BY city, name"
        )->fetchAll();
    }

    /** Basculer le statut de garde (toggle) */
    public function toggleGuard(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE pharmacies SET is_on_guard = NOT is_on_guard WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }

    /** Mettre à jour le profil d'une pharmacie */
    public function updateProfile(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE pharmacies SET name = :name, city = :city, neighborhood = :neighborhood,
             address = :address, phone = :phone WHERE id = :id'
        );
        return $stmt->execute([
            ':name'         => $data['name'],
            ':city'         => $data['city'],
            ':neighborhood' => $data['neighborhood'] ?? '',
            ':address'      => $data['address'] ?? '',
            ':phone'        => $data['phone'] ?? '',
            ':id'           => $id,
        ]);
    }

    /** Créer une nouvelle pharmacie */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO pharmacies (user_id, name, city, neighborhood, address, phone, is_on_guard, is_approved)
             VALUES (:user_id, :name, :city, :neighborhood, :address, :phone, 0, 0)'
        );
        return $stmt->execute([
            ':user_id'      => $data['user_id'],
            ':name'         => $data['name'],
            ':city'         => $data['city'],
            ':neighborhood' => $data['neighborhood'] ?? '',
            ':address'      => $data['address'] ?? '',
            ':phone'        => $data['phone'] ?? '',
        ]);
    }

    /** Pharmacies en attente de validation */
    public function getPending(): array
    {
        return $this->db->query(
            "SELECT * FROM pharmacies WHERE is_approved = 0 ORDER BY created_at ASC"
        )->fetchAll();
    }

    /** Approuver une pharmacie */
    public function approve(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE pharmacies SET is_approved = 1 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    /** Compter toutes les pharmacies */
    public function countAll(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM pharmacies")->fetchColumn();
    }

    /** Compter les pharmacies en attente */
    public function countPending(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM pharmacies WHERE is_approved = 0")->fetchColumn();
    }

    /** Compter les pharmacies actives (approuvées) */
    public function countActive(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM pharmacies WHERE is_approved = 1")->fetchColumn();
    }

    /** Compter les pharmacies de garde actives */
    public function countOnGuard(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM pharmacies WHERE is_on_guard = 1 AND is_approved = 1")->fetchColumn();
    }

    /** Récupérer la liste distincte des villes */
    public function getCities(): array
    {
        return $this->db->query("SELECT DISTINCT city FROM pharmacies WHERE is_approved = 1 ORDER BY city ASC")->fetchAll(PDO::FETCH_COLUMN);
    }

    /** Récupérer les quartiers d'une ville */
    public function getNeighborhoods(string $city): array
    {
        $stmt = $this->db->prepare(
            "SELECT DISTINCT neighborhood FROM pharmacies WHERE city = :city AND is_approved = 1 AND neighborhood != '' ORDER BY neighborhood ASC"
        );
        $stmt->execute([':city' => $city]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}

