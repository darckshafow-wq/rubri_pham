<div class="container">
    <div class="auth-container">

        <!-- Messages Flash -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card auth-card">
            <!-- Onglets Connexion / Inscription Partenaire -->
            <ul class="nav nav-tabs nav-fill" id="authTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#loginPane" type="button" role="tab">
                        <i class="fas fa-sign-in-alt me-1"></i> Connexion
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#registerPane" type="button" role="tab">
                        <i class="fas fa-clinic-medical me-1"></i> Inscription Pharmacie
                    </button>
                </li>
            </ul>

            <div class="card-body p-4">
                <div class="tab-content" id="authTabsContent">

                    <!-- Onglet Connexion -->
                    <div class="tab-pane fade show active" id="loginPane" role="tabpanel">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold">Espace de Connexion</h4>
                            <p class="text-muted small">Accès réservé aux Administrateurs et Pharmacies partenaires</p>
                        </div>

                        <form action="/login" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

                            <div class="mb-3">
                                <label for="email" class="form-label"><i class="fas fa-envelope me-1"></i> Adresse Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="nom@exemple.com" required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label"><i class="fas fa-lock me-1"></i> Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-sign-in-alt me-2"></i> Se Connecter
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Onglet Inscription Partenaire -->
                    <div class="tab-pane fade" id="registerPane" role="tabpanel">
                        <div class="text-center mb-3">
                            <h4 class="fw-bold">Devenir Pharmacie Partenaire</h4>
                            <p class="text-muted small">Inscrivez votre établissement pour gérer vos gardes en direct</p>
                        </div>

                        <div class="info-banner">
                            <i class="fas fa-info-circle me-1"></i> Après soumission, votre pharmacie sera examinée et validée par l'administrateur avant activation.
                        </div>

                        <form action="/register" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

                            <h6 class="text-success fw-bold border-bottom pb-2 mb-3">
                                <i class="fas fa-user me-1"></i> Informations du Responsable
                            </h6>

                            <div class="row g-2 mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Nom complet du responsable *</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Dr. Koffi Yao" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="reg_email" class="form-label">Email professionnel *</label>
                                    <input type="email" class="form-control" id="reg_email" name="email" placeholder="contact@pharmacie.ci" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="reg_password" class="form-label">Mot de passe (min. 6 car.) *</label>
                                    <input type="password" class="form-control" id="reg_password" name="password" placeholder="******" minlength="6" required>
                                </div>
                            </div>

                            <h6 class="text-success fw-bold border-bottom pb-2 mb-3">
                                <i class="fas fa-store me-1"></i> Informations de l'Établissement
                            </h6>

                            <div class="mb-3">
                                <label for="pharmacy_name" class="form-label">Nom de la Pharmacie *</label>
                                <input type="text" class="form-control" id="pharmacy_name" name="pharmacy_name" placeholder="Pharmacie du Bélier" required>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <label for="city" class="form-label">Ville *</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Ex: Yamoussoukro, Abidjan" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="neighborhood" class="form-label">Quartier</label>
                                    <input type="text" class="form-control" id="neighborhood" name="neighborhood" placeholder="Ex: Morofe, Cocody">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Adresse / Repère précis</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Ex: En face de la grande mosquée">
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="form-label">Téléphone direct</label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="+225 07 00 00 00 00">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-paper-plane me-2"></i> Envoyer ma demande d'inscription
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

