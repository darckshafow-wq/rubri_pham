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

        <!-- Barre de recherche interne -->
        <div class="dash-search-input-group">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Recherche rapide...">
            <span class="badge bg-dark text-muted border border-secondary px-1">Ctrl K</span>
        </div>

        <!-- Section Navigation -->
        <div class="dash-nav-section-title">Menu Principal</div>
        <ul class="dash-nav-list">
            <li class="dash-nav-item active">
                <a href="/admin/dashboard">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Vue d'ensemble</span>
                    </span>
                </a>
            </li>
            <li class="dash-nav-item">
                <a href="#pendingSection">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-hourglass-half"></i>
                        <span>En attente</span>
                    </span>
                    <?php if (!empty($stats['pending'])): ?>
                        <span class="dash-nav-badge"><?= (int)$stats['pending'] ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="dash-nav-item">
                <a href="#directorySection">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-hospital"></i>
                        <span>Annuaire complet</span>
                    </span>
                    <span class="text-muted small"><?= (int)$stats['total'] ?></span>
                </a>
            </li>
        </ul>

        <div class="dash-nav-section-title">Navigation Publique</div>
        <ul class="dash-nav-list">
            <li class="dash-nav-item">
                <a href="/" target="_blank">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-globe"></i>
                        <span>Site Public</span>
                    </span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-muted small"></i>
                </a>
            </li>
            <li class="dash-nav-item">
                <a href="/search" target="_blank">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Page Recherche</span>
                    </span>
                </a>
            </li>
        </ul>

        <!-- Profil Administrateur en bas de Sidebar -->
        <div class="dash-sidebar-footer">
            <div class="dash-user-card">
                <div class="dash-user-avatar">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="dash-user-info">
                    <p class="dash-user-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Super Admin') ?></p>
                    <p class="dash-user-role">Super Administrateur</p>
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
                <a href="/admin/dashboard">PhamaGarde</a>
                <i class="fa-solid fa-chevron-right small"></i>
                <span class="active">Super Admin Dashboard</span>
            </div>

            <div class="dash-topbar-actions">
                <span class="btn-dash-action">
                    <i class="fa-solid fa-calendar-day text-success"></i>
                    <span><?= date('d M Y') ?></span>
                </span>
                <a href="/" class="btn-dash-action" target="_blank">
                    <i class="fa-solid fa-eye"></i>
                    <span>Aperçu Public</span>
                </a>
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

            <!-- Titre et sous-titre de la vue -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h4 fw-bold mb-1 text-white">Vue d'ensemble du Réseau</h2>
                    <p class="text-muted small mb-0">Statistiques et modération en temps réel des officines de Côte d'Ivoire</p>
                </div>
            </div>

            <!-- ================================================================
                 3. Grille des Cartes KPIs (Style Fintrixity avec carte verte vedette)
                 ================================================================ -->
            <div class="dash-kpi-grid">

                <!-- 1. Carte Vedette : Vert Émeraude Vibrant (comme la carte orange sur l'image) -->
                <div class="kpi-featured-card">
                    <div class="kpi-card-header">
                        <div class="kpi-card-icon-box">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <span class="badge bg-white text-success fw-bold px-2 py-1 rounded-pill small">
                            <i class="fa-solid fa-bolt me-1"></i> En Direct
                        </span>
                    </div>
                    <p class="kpi-title">Pharmacies de Garde Actives</p>
                    <div class="kpi-value"><?= (int)($stats['on_guard'] ?? 0) ?></div>
                    <p class="kpi-subtitle">Ouvertes et accessibles pour les urgences</p>
                </div>

                <!-- 2. Carte Sombre : Total Pharmacies -->
                <div class="kpi-dark-card">
                    <div class="kpi-card-header">
                        <div class="kpi-card-icon-box">
                            <i class="fa-solid fa-hospital"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-20 text-primary border border-primary px-2 py-1 rounded-pill small">
                            Global
                        </span>
                    </div>
                    <p class="kpi-title">Total des Établissements</p>
                    <div class="kpi-value text-white"><?= (int)($stats['total'] ?? 0) ?></div>
                    <p class="kpi-subtitle">Officines enregistrées dans l'annuaire</p>
                </div>

                <!-- 3. Carte Sombre : En Attente de Validation -->
                <div class="kpi-dark-card">
                    <div class="kpi-card-header">
                        <div class="kpi-card-icon-box text-warning" style="background: rgba(245, 158, 11, 0.15);">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <?php if (!empty($stats['pending'])): ?>
                            <span class="badge bg-warning text-dark fw-bold px-2 py-1 rounded-pill small">
                                Action requise
                            </span>
                        <?php else: ?>
                            <span class="badge bg-secondary text-white px-2 py-1 rounded-pill small">
                                À jour
                            </span>
                        <?php endif; ?>
                    </div>
                    <p class="kpi-title">Demandes en Attente</p>
                    <div class="kpi-value text-warning"><?= (int)($stats['pending'] ?? 0) ?></div>
                    <p class="kpi-subtitle">Nouvelles inscriptions à approuver</p>
                </div>

                <!-- 4. Carte Sombre : Pharmacies Validées -->
                <div class="kpi-dark-card">
                    <div class="kpi-card-header">
                        <div class="kpi-card-icon-box">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-20 text-success border border-success px-2 py-1 rounded-pill small">
                            Conformes
                        </span>
                    </div>
                    <p class="kpi-title">Partenaires Validés</p>
                    <div class="kpi-value text-white"><?= (int)($stats['active'] ?? 0) ?></div>
                    <p class="kpi-subtitle">Comptes autorisés à basculer la garde</p>
                </div>

            </div>

            <!-- ================================================================
                 4. Section des Demandes en Attente (Modération)
                 ================================================================ -->
            <div class="dash-widget-card" id="pendingSection">
                <div class="dash-widget-header">
                    <h3 class="dash-widget-title">
                        <i class="fa-solid fa-user-clock text-warning"></i>
                        <span>Demandes d'inscription en attente de validation</span>
                    </h3>
                    <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill">
                        <?= count($pendingPharmacies ?? []) ?> en attente
                    </span>
                </div>

                <?php if (!empty($pendingPharmacies)): ?>
                    <div class="table-responsive">
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th>Pharmacie</th>
                                    <th>Ville</th>
                                    <th>Quartier</th>
                                    <th>Téléphone</th>
                                    <th>Date d'inscription</th>
                                    <th class="text-end">Validation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendingPharmacies as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-white"><?= htmlspecialchars($item['name']) ?></div>
                                            <?php if (!empty($item['address'])): ?>
                                                <div class="text-muted small"><?= htmlspecialchars($item['address']) ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="text-info fw-semibold"><?= htmlspecialchars($item['city']) ?></span></td>
                                        <td><?= htmlspecialchars($item['neighborhood'] ?? '—') ?></td>
                                        <td>
                                            <a href="tel:<?= htmlspecialchars($item['phone']) ?>" class="text-decoration-none text-light">
                                                <?= htmlspecialchars($item['phone'] ?? '—') ?>
                                            </a>
                                        </td>
                                        <td class="text-muted small"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($item['created_at']))) ?></td>
                                        <td class="text-end">
                                            <form action="/admin/approve/<?= (int)$item['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la validation de cette pharmacie ?');">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                                <button type="submit" class="btn btn-sm btn-dash-primary">
                                                    <i class="fa-solid fa-check me-1"></i> Approuver
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <i class="fa-solid fa-circle-check text-success fa-2x mb-2 d-block"></i>
                        Toutes les pharmacies sont validées. Aucune demande en attente.
                    </div>
                <?php endif; ?>
            </div>

            <!-- ================================================================
                 5. Section Annuaire Complet & Surveillance des Gardes
                 ================================================================ -->
            <div class="dash-widget-card" id="directorySection">
                <div class="dash-widget-header">
                    <h3 class="dash-widget-title">
                        <i class="fa-solid fa-network-wired text-success"></i>
                        <span>Surveillance du Réseau Pharmaceutique</span>
                    </h3>
                </div>

                <?php $allPharmacies = (new Pharmacy())->getAll(); ?>
                <div class="table-responsive">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>Établissement</th>
                                <th>Localisation</th>
                                <th>Contact</th>
                                <th class="text-center">Statut Approbation</th>
                                <th class="text-center">Statut de Garde</th>
                                <th class="text-end">Fiche Publique</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allPharmacies as $ph): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold text-white"><?= htmlspecialchars($ph['name']) ?></div>
                                        <div class="text-muted small"><?= htmlspecialchars($ph['address'] ?? '') ?></div>
                                    </td>
                                    <td>
                                        <span class="badge bg-dark border border-secondary text-light">
                                            <?= htmlspecialchars($ph['city']) ?>
                                        </span>
                                        <?php if (!empty($ph['neighborhood'])): ?>
                                            <span class="text-muted small ms-1"><?= htmlspecialchars($ph['neighborhood']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="tel:<?= htmlspecialchars($ph['phone']) ?>" class="text-decoration-none text-light">
                                            <?= htmlspecialchars($ph['phone'] ?? '—') ?>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ph['is_approved']): ?>
                                            <span class="dash-pill-badge dash-pill-guard">
                                                <i class="fa-solid fa-check"></i> Validé
                                            </span>
                                        <?php else: ?>
                                            <span class="dash-pill-badge dash-pill-pending">
                                                <i class="fa-solid fa-clock"></i> En attente
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ph['is_on_guard']): ?>
                                            <span class="dash-pill-badge dash-pill-guard">
                                                <i class="fa-solid fa-circle text-success" style="font-size: 0.5rem;"></i> DE GARDE
                                            </span>
                                        <?php else: ?>
                                            <span class="dash-pill-badge dash-pill-off">
                                                Hors garde
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <a href="/pharmacy/detail?id=<?= (int)$ph['id'] ?>" class="btn btn-sm btn-dash-action" target="_blank" title="Consulter la fiche détaillée">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Fiche
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</div>
