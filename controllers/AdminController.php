<?php
/**
 * AdminController - Tableau de bord et gestion admin
 */
require_once __DIR__ . '/../models/Pharmacy.php';

function requireAdmin(): void
{
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
        $_SESSION['flash_error'] = 'Accès réservé aux administrateurs.';
        header('Location: /login');
        exit;
    }
}

function adminCsrf(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function adminValidateCsrf(): bool
{
    if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        return false;
    }
    unset($_SESSION['csrf_token']);
    return true;
}

/** Tableau de bord admin avec KPI */
function adminDashboard(): void
{
    requireAdmin();

    $pm = new Pharmacy();
    $stats = [
        'total'    => $pm->countAll(),
        'pending'  => $pm->countPending(),
        'active'   => $pm->countActive(),
        'on_guard' => $pm->countOnGuard(),
    ];
    $pendingPharmacies = $pm->getPending();

    $csrf_token = adminCsrf();
    $error   = $_SESSION['flash_error'] ?? null;
    $success = $_SESSION['flash_success'] ?? null;
    unset($_SESSION['flash_error'], $_SESSION['flash_success']);

    $pageTitle   = 'Super Admin Dashboard';
    $pageCss     = 'admin-dashboard';
    $isDashboard = true;
    $viewPath    = __DIR__ . '/../views/';
    require $viewPath . 'layouts/header.php';
    require $viewPath . 'admin/dashboard.php';
    require $viewPath . 'layouts/footer.php';
}

/** Approuver une pharmacie (POST) */
function approve(int $id): void
{
    requireAdmin();

    if (!adminValidateCsrf()) {
        $_SESSION['flash_error'] = 'Jeton de sécurité invalide.';
        header('Location: /admin/dashboard');
        exit;
    }

    $pm = new Pharmacy();
    $pharmacy = $pm->findById($id);

    if (!$pharmacy) {
        $_SESSION['flash_error'] = 'Pharmacie introuvable.';
        header('Location: /admin/dashboard');
        exit;
    }

    $pm->approve($id);
    $_SESSION['flash_success'] = 'La pharmacie "' . htmlspecialchars($pharmacy['name']) . '" a été approuvée avec succès.';
    header('Location: /admin/dashboard');
    exit;
}
