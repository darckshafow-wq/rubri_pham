<div class="container py-4">

    <!-- En-tête et retour accueil -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1 d-flex align-items-center gap-2">
                <i class="fa-solid fa-magnifying-glass-location text-success"></i>
                <span>Résultats de recherche</span>
            </h1>
            <p class="text-muted small mb-0">Pharmacies validées et enregistrées sur le réseau</p>
        </div>
        <a href="/" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Nouvelle recherche</span>
        </a>
    </div>

    <!-- Barre de filtres rapide -->
    <div class="filter-bar">
        <form action="/search" method="GET" class="row g-2 align-items-center" id="searchForm">
            <div class="col-md-4">
                <select class="form-select" id="citySelect" name="city">
                    <option value="">Toutes les villes</option>
                    <?php if (!empty($cities)): ?>
                        <?php foreach ($cities as $c): ?>
                            <option value="<?= htmlspecialchars($c) ?>" <?= (isset($_GET['city']) && $_GET['city'] === $c) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="neighborhoodSelect" name="neighborhood">
                    <option value="">Tous les quartiers</option>
                    <?php if (!empty($_GET['neighborhood'])): ?>
                        <option value="<?= htmlspecialchars($_GET['neighborhood']) ?>" selected>
                            <?= htmlspecialchars($_GET['neighborhood']) ?>
                        </option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="name" placeholder="Nom..." value="<?= htmlspecialchars($_GET['name'] ?? '') ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100 fw-bold d-flex align-items-center justify-content-center gap-1">
                    <i class="fa-solid fa-filter"></i>
                    <span>Filtrer</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Liste des résultats -->
    <?php if (!empty($pharmacies)): ?>
        <div class="row g-4">
            <?php foreach ($pharmacies as $p): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card pharmacy-result-card h-100 p-3 <?= $p['is_on_guard'] ? 'is-guard' : 'not-guard' ?>">
                        <div class="card-body d-flex flex-column">

                            <!-- En-tête : Nom + Statut de garde -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold text-dark mb-0">
                                    <a href="/pharmacy/detail?id=<?= (int)$p['id'] ?>" class="text-dark text-decoration-none">
                                        <?= htmlspecialchars($p['name']) ?>
                                    </a>
                                </h5>
                                <?php if ($p['is_on_guard']): ?>
                                    <span class="status-pill-guard">
                                        <i class="fa-solid fa-bolt me-1"></i> DE GARDE
                                    </span>
                                <?php else: ?>
                                    <span class="status-pill-off">Hors garde</span>
                                <?php endif; ?>
                            </div>

                            <!-- Localisation -->
                            <p class="text-muted small mb-2">
                                <i class="fa-solid fa-location-dot text-danger me-1"></i>
                                <strong><?= htmlspecialchars($p['city']) ?></strong>
                                <?php if (!empty($p['neighborhood'])): ?>
                                    — <?= htmlspecialchars($p['neighborhood']) ?>
                                <?php endif; ?>
                            </p>

                            <!-- Adresse -->
                            <?php if (!empty($p['address'])): ?>
                                <p class="text-secondary small mb-3">
                                    <i class="fa-solid fa-map-pin text-muted me-1"></i>
                                    <?= htmlspecialchars($p['address']) ?>
                                </p>
                            <?php endif; ?>

                            <!-- Téléphone direct et bouton détails -->
                            <div class="mt-auto pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small"><i class="fa-solid fa-phone me-1"></i> Contact :</span>
                                    <?php if (!empty($p['phone'])): ?>
                                        <a href="tel:<?= htmlspecialchars($p['phone']) ?>" class="phone-link">
                                            <?= htmlspecialchars($p['phone']) ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">Non renseigné</span>
                                    <?php endif; ?>
                                </div>
                                <div class="d-grid mt-2">
                                    <a href="/pharmacy/detail?id=<?= (int)$p['id'] ?>" class="btn btn-sm btn-outline-success">
                                        <i class="fa-solid fa-circle-info me-1"></i> Voir la fiche & itinéraire
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card p-5 text-center shadow-sm border-0">
            <i class="fa-solid fa-magnifying-glass fa-3x text-muted mb-3"></i>
            <h4 class="fw-bold">Aucune pharmacie trouvée</h4>
            <p class="text-muted">Essayez de modifier vos critères de recherche (ville, quartier ou nom).</p>
            <div class="mt-2">
                <a href="/search" class="btn btn-outline-success">
                    <i class="fa-solid fa-rotate-left me-1"></i> Réinitialiser les filtres
                </a>
            </div>
        </div>
    <?php endif; ?>

</div>
