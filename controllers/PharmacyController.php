<?php
/**
 * PharmacyController - Espace partenaire pharmacien
 */
require_once __DIR__ . '/../models/Pharmacy.php';

function requirePharmacy(): void
{
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'pharmacy') {
        $_SESSION['flash_error'] = 'Accès réservé aux pharmaciens.';
        header('Location: /login');
        exit;
    }
}

function pharmCsrf(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function pharmValidateCsrf(): bool
{
    if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        return false;
    }
    unset($_SESSION['csrf_token']);
    return true;
}

/** Tableau de bord pharmacien */
function pharmacyDashboard(): void
{
    requirePharmacy();

    $pharmacy = (new Pharmacy())->findByUserId($_SESSION['user_id']);

    $csrf_token = pharmCsrf();
    $error   = $_SESSION['flash_error'] ?? null;
    $success = $_SESSION['flash_success'] ?? null;
    unset($_SESSION['flash_error'], $_SESSION['flash_success']);

    $pageTitle   = 'Espace Partenaire Pharmacie';
    $pageCss     = 'pharmacy-dashboard';
    $isDashboard = true;
    $viewPath    = __DIR__ . '/../views/';
    require $viewPath . 'layouts/header.php';
    require $viewPath . 'pharmacy/dashboard.php';
    require $viewPath . 'layouts/footer.php';
}

/** Basculer le statut de garde (POST) */
function toggleGuard(): void
{
    requirePharmacy();

    if (!pharmValidateCsrf()) {
        $_SESSION['flash_error'] = 'Jeton de sécurité invalide.';
        header('Location: /pharmacy/dashboard');
        exit;
    }

    $pharmacyModel = new Pharmacy();
    $pharmacy = $pharmacyModel->findByUserId($_SESSION['user_id']);

    if (!$pharmacy) {
        $_SESSION['flash_error'] = 'Pharmacie introuvable.';
        header('Location: /pharmacy/dashboard');
        exit;
    }

    if (!$pharmacy['is_approved']) {
        $_SESSION['flash_error'] = 'Votre pharmacie n\'est pas encore validée par l\'administrateur.';
        header('Location: /pharmacy/dashboard');
        exit;
    }

    $pharmacyModel->toggleGuard($pharmacy['id']);
    $newStatus = $pharmacy['is_on_guard'] ? 'Hors garde' : 'De garde';
    $_SESSION['flash_success'] = "Statut mis à jour : Votre pharmacie est désormais " . $newStatus . ".";
    header('Location: /pharmacy/dashboard');
    exit;
}

/** Mettre à jour le profil (POST) */
function updateProfile(): void
{
    requirePharmacy();

    if (!pharmValidateCsrf()) {
        $_SESSION['flash_error'] = 'Jeton de sécurité invalide.';
        header('Location: /pharmacy/dashboard');
        exit;
    }

    $pharmacyModel = new Pharmacy();
    $pharmacy = $pharmacyModel->findByUserId($_SESSION['user_id']);

    if (!$pharmacy) {
        $_SESSION['flash_error'] = 'Pharmacie introuvable.';
        header('Location: /pharmacy/dashboard');
        exit;
    }

    $name         = trim($_POST['name'] ?? '');
    $city         = trim($_POST['city'] ?? '');
    $neighborhood = trim($_POST['neighborhood'] ?? '');
    $address      = trim($_POST['address'] ?? '');
    $phone        = trim($_POST['phone'] ?? '');

    if (empty($name) || empty($city)) {
        $_SESSION['flash_error'] = 'Le nom et la ville sont obligatoires.';
        header('Location: /pharmacy/dashboard');
        exit;
    }

    $pharmacyModel->updateProfile($pharmacy['id'], [
        'name'         => $name,
        'city'         => $city,
        'neighborhood' => $neighborhood,
        'address'      => $address,
        'phone'        => $phone,
    ]);

    $_SESSION['flash_success'] = 'Informations de l\'établissement mises à jour avec succès.';
    header('Location: /pharmacy/dashboard');
    exit;
}
