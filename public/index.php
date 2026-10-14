<?php
/**
 * phama_garde - Front Controller / Routeur
 */

// Sécurisation du dossier de session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    $savePath = session_save_path();
    if (empty($savePath) || !is_writable($savePath)) {
        session_save_path(sys_get_temp_dir());
    }
    session_start();
}

define('BASE_PATH', dirname(__DIR__));

$uri    = rtrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/') ?: '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Routes dynamiques :
// 1. /admin/approve/{id}
if (preg_match('#^/admin/approve/(\d+)$#', $uri, $m)) {
    require_once BASE_PATH . '/controllers/AdminController.php';
    if ($method === 'POST') {
        approve((int) $m[1]);
    } else {
        http_response_code(405);
        echo '405 - Méthode non autorisée';
    }
    exit;
}

// 2. /pharmacy/{id} ou /pharmacie/{id} ou /pharmacy/detail/{id} (Page détail pharmacie)
if (preg_match('#^/(?:pharmacy|pharmacie)(?:/detail)?/(\d+)$#', $uri, $m)) {
    require_once BASE_PATH . '/controllers/ClientController.php';
    detail((int) $m[1]);
    exit;
}

// Routes statiques
switch ($uri) {
    // --- Public ---
    case '/':
        require_once BASE_PATH . '/controllers/ClientController.php';
        home();
        break;

    case '/search':
        require_once BASE_PATH . '/controllers/ClientController.php';
        search();
        break;

    case '/pharmacy/detail':
    case '/pharmacie/detail':
    case '/detail':
        require_once BASE_PATH . '/controllers/ClientController.php';
        detail();
        break;

    case '/api/neighborhoods':
        require_once BASE_PATH . '/controllers/ClientController.php';
        getNeighborhoods();
        break;

    // --- Auth ---
    case '/login':
        require_once BASE_PATH . '/controllers/AuthController.php';
        $method === 'POST' ? login() : showLogin();
        break;

    case '/register':
        require_once BASE_PATH . '/controllers/AuthController.php';
        $method === 'POST' ? register() : showLogin();
        break;

    case '/logout':
        require_once BASE_PATH . '/controllers/AuthController.php';
        logout();
        break;

    // --- Espace Pharmacien ---
    case '/pharmacy/dashboard':
    case '/pharmacie/dashboard':
        require_once BASE_PATH . '/controllers/PharmacyController.php';
        pharmacyDashboard();
        break;

    case '/pharmacy/toggle-guard':
    case '/pharmacie/toggle-guard':
        require_once BASE_PATH . '/controllers/PharmacyController.php';
        if ($method === 'POST') {
            toggleGuard();
        } else {
            http_response_code(405);
            echo '405 - Méthode non autorisée';
        }
        break;

    case '/pharmacy/update-profile':
    case '/pharmacie/update-profile':
        require_once BASE_PATH . '/controllers/PharmacyController.php';
        if ($method === 'POST') {
            updateProfile();
        } else {
            http_response_code(405);
            echo '405 - Méthode non autorisée';
        }
        break;

    // --- Admin ---
    case '/admin/dashboard':
        require_once BASE_PATH . '/controllers/AdminController.php';
        adminDashboard();
        break;

    // --- 404 ---
    default:
        http_response_code(404);
        echo '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><title>404</title>';
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '</head><body><div class="container text-center py-5">';
        echo '<h1 class="display-1 text-muted">404</h1><p class="lead">Page introuvable</p>';
        echo '<a href="/" class="btn btn-success">Retour à l\'accueil</a></div></body></html>';
        break;
}
