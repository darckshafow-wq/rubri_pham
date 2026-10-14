<div class="dashboard-app-container">

    <!-- ====================================================================
         1. Barre Latérale (Sidebar) - Inspirée de la maquette
         ==================================================================== -->
    <aside class="dash-sidebar">
        <!-- Logo de marque -->
        <a href="/" class="dash-brand">
            <div class="dash-brand-icon">
                <i class="fa-solid fa-mortar-pestle"></i>
            </div>
            <span>PhamaGarde</span>
        </a>

        <!-- Statut Badge Pro -->
        <div class="px-2 mb-3">
            <span class="badge bg-success bg-opacity-15 border border-success text-success px-2 py-1 rounded-pill small w-100 text-center">
                <i class="fa-solid fa-hospital-user me-1"></i> Espace Partenaire
            </span>
        </div>

        <!-- Section Navigation -->
        <div class="dash-nav-section-title">Gestion</div>
        <ul class="dash-nav-list">
            <li class="dash-nav-item active">
                <a href="/pharmacy/dashboard">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-gauge-high"></i>
                        <span>Mon Tableau de Bord</span>
                    </span>
                </a>
            </li>
            <li class="dash-nav-item">
                <a href="#profileSection">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Modifier Coordonnées</span>
                    </span>
                </a>
            </li>
            <?php if (!empty($pharmacy['id'])): ?>
            <li class="dash-nav-item">
                <a href="/pharmacy/detail?id=<?= (int)$pharmacy['id'] ?>" target="_blank">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-eye"></i>
                        <span>Voir Ma Fiche Client</span>
                    </span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-muted small"></i>
                </a>
            </li>
            <?php endif; ?>
        </ul>

        <div class="dash-nav-section-title">Navigation Publique</div>
        <ul class="dash-nav-list">
            <li class="dash-nav-item">
                <a href="/" target="_blank">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-house"></i>
                        <span>Accueil Public</span>
                    </span>
                </a>
            </li>
            <li class="dash-nav-item">
                <a href="/search" target="_blank">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Recherche Gardes</span>
                    </span>
                </a>
            </li>
        </ul>

        <!-- Profil Pharmacien en bas de Sidebar -->
        <div class="dash-sidebar-footer">
            <div class="dash-user-card">
                <div class="dash-user-avatar">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <div class="dash-user-info">
                    <p class="dash-user-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Pharmacien') ?></p>
                    <p class="dash-user-role"><?= htmlspecialchars($pharmacy['city'] ?? 'Côte d\'Ivoire') ?></p>
                </div>
                <a href="/logout" class="text-danger ps-1" title="Déconnexion">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- ====================================================================
         2. Zone de Contenu Principale
         ==================================================================== -->
    <main class="dash-content-area">

        <!-- Barre Supérieure (Topbar) -->
        <header class="dash-topbar">
            <div class="dash-breadcrumbs">
                <a href="/pharmacy/dashboard">PhamaGarde</a>
                <i class="fa-solid fa-chevron-right small"></i>
                <span class="active"><?= htmlspecialchars($pharmacy['name'] ?? 'Mon Établissement') ?></span>
            </div>

            <div class="dash-topbar-actions">
                <?php if (!empty($pharmacy['is_approved'])): ?>
                    <span class="badge bg-success bg-opacity-20 text-success border border-success px-3 py-2 rounded-pill small">
                        <i class="fa-solid fa-circle-check me-1"></i> Officine Approuvée
                    </span>
                <?php else: ?>
                    <span class="badge bg-warning bg-opacity-20 text-warning border border-warning px-3 py-2 rounded-pill small">
                        <i class="fa-solid fa-clock me-1"></i> En Attente Validation
                    </span>
                <?php endif; ?>

                <?php if (!empty($pharmacy['id'])): ?>
                    <a href="/pharmacy/detail?id=<?= (int)$pharmacy['id'] ?>" class="btn-dash-action" target="_blank">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        <span>Ma Fiche Publique</span>
                    </a>
                <?php endif; ?>

                <a href="/logout" class="btn-dash-action text-danger border-danger">
                    <i class="fa-solid fa-power-off"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </header>

        <!-- Contenu Déroulant -->
        <div class="dash-main-scroll">

            <!-- Messages Flash -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show bg-danger bg-opacity-10 border-danger text-danger" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i><?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success alert-dismissible fade show bg-success bg-opacity-10 border-success text-success" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i><?= htmlspecialchars($success) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Alerte si non approuvé -->
            <?php if (empty($pharmacy['is_approved'])): ?>
                <div class="card bg-warning bg-opacity-10 border border-warning text-warning p-4 rounded-4 mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa-solid fa-triangle-exclamation fa-2x"></i>
                        <div>
                            <h5 class="fw-bold mb-1">Votre établissement est en attente de validation</h5>
                            <p class="mb-0 small text-light opacity-75">
                                Un administrateur doit valider votre compte avant l'activation du bouton de garde. Vos informations sont déjà enregistrées.
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ================================================================
                 3. Grand Interrupteur de Garde (Hero Switch)
                 ================================================================ -->
            <div class="guard-control-hero-card <?= !empty($pharmacy['is_on_guard']) ? 'is-active-guard' : '' ?>">
                <div class="guard-hero-header">
                    <div class="guard-status-display">
                        <div class="guard-indicator-glow <?= !empty($pharmacy['is_on_guard']) ? 'active' : '' ?>"></div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold letter-spacing-1">Statut en direct pour le public</span>
                            <h2 class="guard-status-text <?= !empty($pharmacy['is_on_guard']) ? 'active' : '' ?>">
                                <?= !empty($pharmacy['is_on_guard']) ? 'PHARMACIE ACTUELLEMENT DE GARDE' : 'PHARMACIE EN SERVICE STANDARD (HORS GARDE)' ?>
                            </h2>
                        </div>
                    </div>

                    <!-- Interrupteur Interactif -->
                    <?php if (!empty($pharmacy['is_approved'])): ?>
                        <form action="/pharmacy/toggle-guard" method="POST" id="toggleGuardForm">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                            <div class="switch-wrapper">
                                <span class="small fw-bold text-white"><?= !empty($pharmacy['is_on_guard']) ? 'DE GARDE' : 'HORS GARDE' ?></span>
                                <label class="modern-switch">
                                    <input type="checkbox" id="guardSwitch" <?= !empty($pharmacy['is_on_guard']) ? 'checked' : '' ?> onchange="document.getElementById('toggleGuardForm').submit();">
                                    <span class="modern-slider"></span>
                                </label>
                            </div>
                        </form>
                    <?php else: ?>
                        <span class="badge bg-secondary p-2 px-3 rounded-pill text-white small">
                            <i class="fa-solid fa-lock me-1"></i> Interrupteur Verrouillé
                        </span>
                    <?php endif; ?>
                </div>

                <div class="border-top border-secondary border-opacity-25 pt-3 d-flex flex-wrap justify-content-between align-items-center">
                    <p class="text-muted small mb-0">
                        <i class="fa-solid fa-circle-info text-info me-1"></i>
                        <?php if (!empty($pharmacy['is_on_guard'])): ?>
                            Votre pharmacie est mise en avant en tête de liste avec le badge vert et votre numéro d'appel.
                        <?php else: ?>
                            Votre pharmacie apparaît dans les résultats avec son statut régulier.
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($pharmacy['is_approved'])): ?>
                        <form action="/pharmacy/toggle-guard" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                            <button type="submit" class="btn btn-sm btn-outline-<?= !empty($pharmacy['is_on_guard']) ? 'danger' : 'success' ?> rounded-pill px-3">
                                <i class="fa-solid fa-power-off me-1"></i>
                                <?= !empty($pharmacy['is_on_guard']) ? 'Désactiver la garde' : 'Activer le mode garde' ?>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ================================================================
                 4. Grille de Gestion : Formulaire Profil + Aperçu Client
                 ================================================================ -->
            <div class="row g-4" id="profileSection">

                <!-- Colonne 1 : Modification des Coordonnées -->
                <div class="col-lg-7">
                    <div class="dash-card-dark h-100">
                        <h3 class="dash-card-title">
                            <i class="fa-solid fa-pen-to-square text-success"></i>
                            <span>Coordonnées de l'Établissement</span>
                        </h3>

                        <form action="/pharmacy/update-profile" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

                            <div class="mb-3">
                                <label for="name" class="dash-form-label">Nom officiel de la Pharmacie *</label>
                                <input type="text" class="dash-form-control" id="name" name="name" value="<?= htmlspecialchars($pharmacy['name'] ?? '') ?>" required>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="city" class="dash-form-label">Ville *</label>
                                    <input type="text" class="dash-form-control" id="city" name="city" value="<?= htmlspecialchars($pharmacy['city'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="neighborhood" class="dash-form-label">Quartier</label>
                                    <input type="text" class="dash-form-control" id="neighborhood" name="neighborhood" value="<?= htmlspecialchars($pharmacy['neighborhood'] ?? '') ?>" placeholder="Ex: Cocody, Plateau...">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="dash-form-label">Adresse / Repères précis pour les usagers</label>
                                <textarea class="dash-form-control" id="address" name="address" rows="3" placeholder="Ex: En face de la grande mosquée, boulevard principal..."><?= htmlspecialchars($pharmacy['address'] ?? '') ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="dash-form-label">Numéro de Téléphone Direct (Urgences & Garde)</label>
                                <input type="tel" class="dash-form-control" id="phone" name="phone" value="<?= htmlspecialchars($pharmacy['phone'] ?? '') ?>" placeholder="+225 07 00 00 00 00">
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="dash-btn-save">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    <span>Enregistrer les modifications</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Colonne 2 : Aperçu Visuel Client -->
                <div class="col-lg-5">
                    <div class="dash-card-dark h-100 d-flex flex-column">
                        <h3 class="dash-card-title">
                            <i class="fa-solid fa-mobile-screen-button text-info"></i>
                            <span>Aperçu de votre Fiche Client</span>
                        </h3>
                        <p class="text-muted small">Voici exactement la carte affichée aux patients lorsqu'ils effectuent une recherche :</p>

                        <div class="client-preview-card mt-auto mb-auto">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold text-white mb-0"><?= htmlspecialchars($pharmacy['name'] ?? 'Ma Pharmacie') ?></h5>
                                <?php if (!empty($pharmacy['is_on_guard'])): ?>
                                    <span class="badge bg-success bg-opacity-25 border border-success text-success px-2 py-1 rounded-pill small">
                                        <i class="fa-solid fa-bolt me-1"></i> DE GARDE
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary bg-opacity-20 text-muted px-2 py-1 rounded-pill small">
                                        Hors garde
                                    </span>
                                <?php endif; ?>
                            </div>

                            <p class="text-muted small mb-2">
                                <i class="fa-solid fa-location-dot text-danger me-1"></i>
                                <span class="text-light"><?= htmlspecialchars($pharmacy['city'] ?? 'Ville') ?></span>
                                <?php if (!empty($pharmacy['neighborhood'])): ?>
                                    — <?= htmlspecialchars($pharmacy['neighborhood']) ?>
                                <?php endif; ?>
                            </p>

                            <?php if (!empty($pharmacy['address'])): ?>
                                <p class="text-muted small mb-3">
                                    <i class="fa-solid fa-map-pin text-secondary me-1"></i>
                                    <?= htmlspecialchars($pharmacy['address']) ?>
                                </p>
                            <?php endif; ?>

                            <div class="border-top border-secondary border-opacity-25 pt-2 d-flex justify-content-between align-items-center">
                                <span class="text-muted small">Contact public :</span>
                                <span class="text-success fw-bold"><?= htmlspecialchars($pharmacy['phone'] ?? 'Non renseigné') ?></span>
                            </div>
                        </div>

                        <?php if (!empty($pharmacy['id'])): ?>
                            <div class="mt-3 text-center">
                                <a href="/pharmacy/detail?id=<?= (int)$pharmacy['id'] ?>" target="_blank" class="btn btn-sm btn-outline-success w-100 rounded-pill">
                                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Ouvrir la page de détail complète
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>
    </main>

</div>
