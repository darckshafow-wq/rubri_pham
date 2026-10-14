<?php
/**
 * AuthController - Connexion, Inscription, Déconnexion
 */
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Pharmacy.php';

// === Helpers ===

function generateCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCsrfToken(): bool
{
    if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        return false;
    }
    unset($_SESSION['csrf_token']);
    return true;
}

function redirectByRole(string $role): void
{
    header('Location: ' . ($role === 'admin' ? '/admin/dashboard' : '/pharmacy/dashboard'));
    exit;
}

// === Actions ===

/** Afficher la page de connexion / inscription */
function showLogin(): void
{
    if (isset($_SESSION['user_id'])) {
        redirectByRole($_SESSION['user_role']);
    }

    $csrf_token = generateCsrfToken();
    $error   = $_SESSION['flash_error'] ?? null;
    $success = $_SESSION['flash_success'] ?? null;
    unset($_SESSION['flash_error'], $_SESSION['flash_success']);

    $pageTitle = 'Connexion / Inscription';
    $pageCss   = 'auth';
    $viewPath  = __DIR__ . '/../views/';
    require $viewPath . 'layouts/header.php';
    require $viewPath . 'auth/login.php';
    require $viewPath . 'layouts/footer.php';
}

/** Traiter le POST de connexion */
function login(): void
{
    if (!validateCsrfToken()) {
        $_SESSION['flash_error'] = 'Jeton de sécurité invalide.';
        header('Location: /login');
        exit;
    }

    $email    = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['flash_error'] = 'Veuillez remplir tous les champs.';
        header('Location: /login');
        exit;
    }

    $user = (new User())->findByEmail($email);

    if (!$user || !password_verify($password, $user['password'])) {
        $_SESSION['flash_error'] = 'Email ou mot de passe incorrect.';
        header('Location: /login');
        exit;
    }

    session_regenerate_id(true);
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_role'] = $user['role'];

    redirectByRole($user['role']);
}

/** Traiter le POST d'inscription pharmacie */
function register(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        showLogin();
        return;
    }

    if (!validateCsrfToken()) {
        $_SESSION['flash_error'] = 'Jeton de sécurité invalide.';
        header('Location: /login');
        exit;
    }

    $name          = trim($_POST['name'] ?? '');
    $email         = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password      = $_POST['password'] ?? '';
    $pharmacyName  = trim($_POST['pharmacy_name'] ?? '');
    $city          = trim($_POST['city'] ?? '');
    $neighborhood  = trim($_POST['neighborhood'] ?? '');
    $address       = trim($_POST['address'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');

    if (empty($name) || empty($email) || empty($password) || empty($pharmacyName) || empty($city)) {
        $_SESSION['flash_error'] = 'Veuillez remplir tous les champs obligatoires.';
        header('Location: /login');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash_error'] = 'Adresse email invalide.';
        header('Location: /login');
        exit;
    }

    if (strlen($password) < 6) {
        $_SESSION['flash_error'] = 'Le mot de passe doit contenir au moins 6 caractères.';
        header('Location: /login');
        exit;
    }

    $userModel = new User();

    if ($userModel->findByEmail($email)) {
        $_SESSION['flash_error'] = 'Cette adresse email est déjà utilisée.';
        header('Location: /login');
        exit;
    }

    $userId = $userModel->create([
        'name'     => $name,
        'email'    => $email,
        'password' => $password,
        'role'     => 'pharmacy',
    ]);

    if (!$userId) {
        $_SESSION['flash_error'] = 'Erreur lors de la création du compte.';
        header('Location: /login');
        exit;
    }

    (new Pharmacy())->create([
        'user_id'      => $userId,
        'name'         => $pharmacyName,
        'city'         => $city,
        'neighborhood' => $neighborhood,
        'address'      => $address,
        'phone'        => $phone,
    ]);

    $_SESSION['flash_success'] = 'Inscription réussie ! Votre pharmacie sera validée par un administrateur.';
    header('Location: /login');
    exit;
}

/** Déconnexion */
function logout(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
    header('Location: /');
    exit;
}

