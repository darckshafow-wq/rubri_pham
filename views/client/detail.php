<?php
// Nettoyage du numéro de téléphone pour le lien tel: (suppression des espaces et caractères non numériques sauf +)
$cleanPhone = !empty($pharmacy['phone']) ? preg_replace('/[^0-9+]/', '', $pharmacy['phone']) : '';
?>

<!-- En-tête Médical -->
<section class="detail-hero">
    <div class="container">
        <!-- Fil d'Ariane -->
        <nav class="detail-breadcrumbs" aria-label="breadcrumb">
            <a href="/"><i class="fa-solid fa-house me-1"></i> Accueil</a>
            <span class="mx-2">/</span>
            <a href="/search">Recherche</a>
            <span class="mx-2">/</span>
            <span class="opacity-75"><?= htmlspecialchars($pharmacy['name'] ?? 'Détails') ?></span>
        </nav>

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h1 class="detail-title text-white"><?= htmlspecialchars($pharmacy['name'] ?? 'Pharmacie') ?></h1>
                <p class="mb-0 text-white-50 fs-5">
                    <i class="fa-solid fa-location-dot me-1 text-warning"></i>
                    <strong><?= htmlspecialchars($pharmacy['city'] ?? 'Côte d\'Ivoire') ?></strong>
                    <?php if (!empty($pharmacy['neighborhood'])): ?>
                        — Quartier <?= htmlspecialchars($pharmacy['neighborhood']) ?>
                    <?php endif; ?>
                </p>
            </div>

            <div>
                <?php if (!empty($pharmacy['is_on_guard'])): ?>
                    <span class="detail-guard-badge active shadow">
                        <i class="fa-solid fa-shield-halved"></i> PHARMACIE DE GARDE
                    </span>
                <?php else: ?>
                    <span class="detail-guard-badge inactive shadow-sm">
                        <i class="fa-solid fa-clock"></i> Service Régulier (Hors garde)
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Fiche Principale -->
<div class="container mb-5">
    <div class="detail-main-card">

        <!-- Bannière d'avertissement si non approuvée -->
        <?php if (empty($pharmacy['is_approved'])): ?>
            <div class="alert alert-warning d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="fa-solid fa-triangle-exclamation fs-5"></i>
                <div>
                    <strong>Établissement en cours de vérification :</strong> Cette pharmacie a récemment soumis son inscription et est en attente d'approbation par les administrateurs.
                </div>
            </div>
        <?php endif; ?>

        <div class="row g-4">

            <!-- Colonne Gauche : Coordonnées & Appel d'urgence -->
            <div class="col-lg-7">
                <h3 class="h5 fw-bold mb-3 text-dark d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-info text-success"></i>
                    <span>Informations & Coordonnées</span>
                </h3>

                <!-- Bouton d'Appel Direct -->
                <?php if (!empty($pharmacy['phone'])): ?>
                    <div class="mb-4">
                        <a href="tel:<?= htmlspecialchars($cleanPhone) ?>" class="btn-call-emergency">
                            <i class="fa-solid fa-phone-volume"></i>
                            <span>Appeler : <?= htmlspecialchars($pharmacy['phone']) ?></span>
                        </a>
                        <p class="text-center text-muted small mt-2">
                            <i class="fa-solid fa-shield-halved text-success me-1"></i> Ligne directe de l'officine pour vos urgences
                        </p>
                    </div>
                <?php else: ?>
                    <div class="alert alert-secondary text-muted small mb-4">
                        <i class="fa-solid fa-phone-slash me-1"></i> Numéro de téléphone direct non renseigné par l'officine.
                    </div>
                <?php endif; ?>

                <!-- Détail de l'adresse -->
                <div class="info-item-box">
                    <div class="info-item-icon">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <div>
                        <span class="text-muted small text-uppercase fw-bold">Adresse & Repères d'accès</span>
                        <div class="fw-semibold text-dark fs-6 mt-1">
                            <?= !empty($pharmacy['address']) ? nl2br(htmlspecialchars($pharmacy['address'])) : 'Adresse non précisée' ?>
                        </div>
                        <div class="text-secondary small mt-1">
                            <strong>Ville :</strong> <?= htmlspecialchars($pharmacy['city'] ?? 'Non précisée') ?> 
                            <?php if (!empty($pharmacy['neighborhood'])): ?>
                                | <strong>Quartier :</strong> <?= htmlspecialchars($pharmacy['neighborhood']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Disponibilité & Statut -->
                <div class="info-item-box">
                    <div class="info-item-icon" style="background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div>
                        <span class="text-muted small text-uppercase fw-bold">Régime d'ouverture</span>
                        <div class="fw-semibold text-dark fs-6 mt-1">
                            <?php if (!empty($pharmacy['is_on_guard'])): ?>
                                <span class="text-success fw-bold">
                                    <i class="fa-solid fa-circle-check me-1"></i> Ouverte pour la garde d'urgence (Nuit & Jour Férié)
                                </span>
                            <?php else: ?>
                                <span class="text-secondary">
                                    <i class="fa-solid fa-store me-1"></i> Service habituel en journée
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="text-muted small mt-1">
                            Statut contrôlé et mis à jour en temps réel par le titulaire de l'officine.
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a href="/search?city=<?= urlencode($pharmacy['city'] ?? '') ?>" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i> Autres pharmacies à <?= htmlspecialchars($pharmacy['city'] ?? '') ?>
                    </a>
                    <button type="button" class="btn btn-outline-success" id="btnSharePharmacy">
                        <i class="fa-solid fa-share-nodes me-1"></i> Partager cette fiche
                    </button>
                </div>
            </div>

            <!-- Colonne Droite : Localisation & Conseils Santé -->
            <div class="col-lg-5">
                <div class="map-placeholder-box mb-4">
                    <i class="fa-solid fa-map-location map-bg-icon"></i>
                    <i class="fa-solid fa-location-crosshairs fa-3x text-success mb-3"></i>
                    <h5 class="fw-bold">Repère Géographique</h5>
                    <p class="small text-light opacity-75 mb-3">
                        <?= htmlspecialchars($pharmacy['city'] ?? '') ?>
                        <?php if (!empty($pharmacy['neighborhood'])): ?>
                            — <?= htmlspecialchars($pharmacy['neighborhood']) ?>
                        <?php endif; ?>
                    </p>
                    <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode(($pharmacy['name'] ?? '') . ' ' . ($pharmacy['city'] ?? '') . ' ' . ($pharmacy['neighborhood'] ?? '') . ' Cote d Ivoire') ?>"
                       target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-light text-dark fw-bold rounded-pill px-3 shadow-sm">
                        <i class="fa-solid fa-diamond-turn-right text-success me-1"></i> Ouvrir dans GPS / Google Maps
                    </a>
                </div>

                <div class="card border-0 bg-light p-3 rounded-3 shadow-sm">
                    <h6 class="fw-bold text-dark mb-2">
                        <i class="fa-solid fa-kit-medical text-danger me-1"></i> Recommandations d'Urgence
                    </h6>
                    <ul class="text-muted small ps-3 mb-0">
                        <li class="mb-1">Munissez-vous de votre ordonnance médicale en cours de validité.</li>
                        <li class="mb-1">Prévoyez une pièce d'identité pour la délivrance de certains traitements.</li>
                        <li class="mb-1">En garde de nuit, sonnez ou appelez au numéro indiqué avant de vous déplacer.</li>
                        <li>En cas de détresse vitale absolue, alertez le SAMU (185 / 15).</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
// Script de partage sécurisé avec fallback
document.addEventListener('DOMContentLoaded', function() {
    const shareBtn = document.getElementById('btnSharePharmacy');
    if (shareBtn) {
        shareBtn.addEventListener('click', function() {
            const url = window.location.href;
            if (navigator.share) {
                navigator.share({
                    title: '<?= addslashes(htmlspecialchars($pharmacy['name'] ?? 'Pharmacie')) ?>',
                    text: 'Coordonnées et statut de garde de la <?= addslashes(htmlspecialchars($pharmacy['name'] ?? 'Pharmacie')) ?> sur Phama Garde',
                    url: url
                }).catch(function(err) {
                    console.log('Partage annulé ou non supporté');
                });
            } else if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(function() {
                    alert('Lien de la fiche copié dans votre presse-papier !');
                }).catch(function() {
                    prompt('Copiez le lien de la pharmacie :', url);
                });
            } else {
                prompt('Copiez le lien de la pharmacie :', url);
            }
        });
    }
});
</script>
