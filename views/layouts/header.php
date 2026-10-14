<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Phama Garde') ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 Pro / Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- CSS global -->
    <link rel="stylesheet" href="/assets/css/global.css">
    <!-- CSS dédié à la page -->
    <?php if (!empty($pageCss)): ?>
        <link rel="stylesheet" href="/assets/css/<?= htmlspecialchars($pageCss) ?>.css">
    <?php endif; ?>
</head>
<body class="<?= !empty($isDashboard) ? 'dashboard-layout-body' : '' ?>">

<?php if (empty($isDashboard)): ?>
<!-- Barre de navigation publique standard -->
<nav class="navbar navbar-expand-lg navbar-dark bg-pharmacy">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/">
            <i class="fa-solid fa-mortar-pestle fs-4 text-white"></i>
            <span>Phama Garde</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="fa-solid fa-house me-1"></i> Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/search">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Rechercher
                    </a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/dashboard">
                                <i class="fa-solid fa-chart-line me-1"></i> Administration
                            </a>
                        </li>
                    <?php elseif ($_SESSION['user_role'] === 'pharmacy'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/pharmacy/dashboard">
                                <i class="fa-solid fa-hospital-user me-1"></i> Mon Espace
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-sm btn-outline-light d-flex align-items-center gap-2" href="/logout">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>Déconnexion</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-sm btn-light text-success fw-bold d-flex align-items-center gap-2" href="/login">
                            <i class="fa-solid fa-user-lock"></i>
                            <span>Espace Pro</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php endif; ?>

<main class="<?= !empty($isDashboard) ? 'dashboard-main-area' : '' ?>">
