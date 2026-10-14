<!-- Section Héro -->
<section class="hero-banner text-center">
    <div class="container">
        <h1 class="hero-title d-flex align-items-center justify-content-center gap-3 flex-wrap">
            <i class="fa-solid fa-mortar-pestle text-white"></i>
            <span>Trouvez votre pharmacie de garde</span>
        </h1>
        <p class="hero-subtitle">
            Localisez instantanément les officines ouvertes et de garde les plus proches en Côte d'Ivoire.
        </p>
    </div>
</section>

<!-- Boîte de Recherche Interactive -->
<div class="container mb-5">
    <div class="search-box-card">
        <form action="/search" method="GET" id="searchForm">
            <div class="row g-3 align-items-end">

                <!-- Filtre par Ville -->
                <div class="col-md-4">
                    <label for="citySelect" class="form-label">
                        <i class="fa-solid fa-map-location-dot text-success me-1"></i> Ville
                    </label>
                    <select class="form-select" id="citySelect" name="city">
                        <option value="">Toutes les villes</option>
                        <?php if (!empty($cities)): ?>
                            <?php foreach ($cities as $c): ?>
                                <option value="<?= htmlspecialchars($c) ?>"><?= htmlspecialchars($c) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Filtre par Quartier (chargé dynamiquement en JS) -->
                <div class="col-md-3">
                    <label for="neighborhoodSelect" class="form-label">
                        <i class="fa-solid fa-location-crosshairs text-success me-1"></i> Quartier
                    </label>
                    <select class="form-select" id="neighborhoodSelect" name="neighborhood">
                        <option value="">Tous les quartiers</option>
                    </select>
                </div>

                <!-- Filtre par Nom de Pharmacie -->
                <div class="col-md-3">
                    <label for="nameInput" class="form-label">
                        <i class="fa-solid fa-magnifying-glass text-success me-1"></i> Nom de pharmacie
                    </label>
                    <input type="text" class="form-control" id="nameInput" name="name" placeholder="Ex: Bélier, Cocotiers...">
                </div>

                <!-- Bouton Soumettre -->
                <div class="col-md-2">
                    <button type="submit" class="btn search-btn w-100 d-flex align-items-center justify-content-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Chercher</span>
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- Section des Pharmacies Actuellement De Garde -->
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1 d-flex align-items-center gap-2">
                <i class="fa-solid fa-shield-halved text-success"></i>
                <span>Pharmacies actuellement de garde</span>
            </h2>
            <p class="text-muted small mb-0">Établissements validés et disponibles pour vos urgences</p>
        </div>
        <a href="/search" class="btn btn-outline-success btn-sm d-flex align-items-center gap-1">
            <span>Voir toutes les pharmacies</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <?php if (!empty($pharmaciesDeGarde)): ?>
        <div class="row g-4">
            <?php foreach ($pharmaciesDeGarde as $pharmacie): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card guard-card h-100 p-3">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold mb-0 text-dark">
                                    <a href="/pharmacy/detail?id=<?= (int)$pharmacie['id'] ?>" class="text-dark text-decoration-none">
                                        <?= htmlspecialchars($pharmacie['name']) ?>
                                    </a>
                                </h5>
                                <span class="badge-guard">
                                    <i class="fa-solid fa-bolt me-1"></i> De Garde
                                </span>
                            </div>

                            <p class="text-muted small mb-2">
                                <i class="fa-solid fa-location-dot text-danger me-1"></i>
                                <strong><?= htmlspecialchars($pharmacie['city']) ?></strong>
                                <?php if (!empty($pharmacie['neighborhood'])): ?>
                                    — <?= htmlspecialchars($pharmacie['neighborhood']) ?>
                                <?php endif; ?>
                            </p>

                            <?php if (!empty($pharmacie['address'])): ?>
                                <p class="text-secondary small mb-3">
                                    <i class="fa-solid fa-map-pin text-muted me-1"></i>
                                    <?= htmlspecialchars($pharmacie['address']) ?>
                                </p>
                            <?php endif; ?>

                            <div class="mt-auto pt-3 border-top">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted small"><i class="fa-solid fa-phone me-1"></i> Appel direct :</span>
                                    <?php if (!empty($pharmacie['phone'])): ?>
                                        <a href="tel:<?= htmlspecialchars($pharmacie['phone']) ?>" class="pharmacy-phone">
                                            <?= htmlspecialchars($pharmacie['phone']) ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">Non renseigné</span>
                                    <?php endif; ?>
                                </div>
                                <div class="d-grid mt-2">
                                    <a href="/pharmacy/detail?id=<?= (int)$pharmacie['id'] ?>" class="btn btn-sm btn-outline-success">
                                        <i class="fa-solid fa-circle-info me-1"></i> Voir la fiche complète
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center py-4">
            <i class="fa-solid fa-circle-info fa-2x mb-2 d-block"></i>
            Aucune pharmacie n'est enregistrée de garde actuellement.
        </div>
    <?php endif; ?>
</div>
