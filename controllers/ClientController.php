<?php
/**
 * ClientController - Pages publiques (accueil, recherche, détail)
 */
require_once __DIR__ . '/../models/Pharmacy.php';

/** Page d'accueil avec barre de recherche */
function home(): void
{
    $pharmacyModel = new Pharmacy();
    $cities            = $pharmacyModel->getCities();
    $pharmaciesDeGarde = $pharmacyModel->getOnGuard();

    $pageTitle = 'Trouvez votre pharmacie de garde';
    $pageCss   = 'home';
    $viewPath  = __DIR__ . '/../views/';
    require $viewPath . 'layouts/header.php';
    require $viewPath . 'client/home.php';
    require $viewPath . 'layouts/footer.php';
}

/** Résultats de recherche filtrés */
function search(): void
{
    $city         = !empty($_GET['city']) ? trim($_GET['city']) : null;
    $neighborhood = !empty($_GET['neighborhood']) ? trim($_GET['neighborhood']) : null;
    $name         = !empty($_GET['name']) ? trim($_GET['name']) : null;

    $pharmacyModel = new Pharmacy();
    $pharmacies = $pharmacyModel->search($city, $neighborhood, $name);
    $cities     = $pharmacyModel->getCities();

    $pageTitle = 'Résultats de recherche';
    $pageCss   = 'results';
    $viewPath  = __DIR__ . '/../views/';
    require $viewPath . 'layouts/header.php';
    require $viewPath . 'client/results.php';
    require $viewPath . 'layouts/footer.php';
}

/** Page de détail complète d'une pharmacie */
function detail(?int $id = null): void
{
    $pharmacyId = $id ?? (int)($_GET['id'] ?? 0);

    if ($pharmacyId <= 0) {
        header('Location: /search');
        exit;
    }

    $pharmacyModel = new Pharmacy();
    $pharmacy = $pharmacyModel->findById($pharmacyId);

    if (!$pharmacy) {
        http_response_code(404);
        echo '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><title>Pharmacie non trouvée</title>';
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '</head><body class="bg-light"><div class="container text-center py-5">';
        echo '<h1 class="display-4 text-muted">Pharmacie Introuvable</h1>';
        echo '<p class="lead">L\'établissement demandé n\'existe pas ou a été déplacé.</p>';
        echo '<a href="/search" class="btn btn-success">Retour à la recherche</a>';
        echo '</div></body></html>';
        exit;
    }

    $pageTitle = htmlspecialchars($pharmacy['name']) . ' - Détails & Garde';
    $pageCss   = 'detail';
    $viewPath  = __DIR__ . '/../views/';
    require $viewPath . 'layouts/header.php';
    require $viewPath . 'client/detail.php';
    require $viewPath . 'layouts/footer.php';
}

/** API JSON : quartiers d'une ville */
function getNeighborhoods(): void
{
    header('Content-Type: application/json; charset=utf-8');
    $city = trim($_GET['city'] ?? '');

    if (empty($city)) {
        echo json_encode(['neighborhoods' => []]);
        return;
    }

    $neighborhoods = (new Pharmacy())->getNeighborhoods($city);
    echo json_encode(['neighborhoods' => $neighborhoods]);
}
