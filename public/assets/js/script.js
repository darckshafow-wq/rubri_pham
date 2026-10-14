/**
 * Phama Garde - Scripts JavaScript (script.js)
 */

document.addEventListener('DOMContentLoaded', function () {

    // ==========================================================================
    // 1. Chargement dynamique des quartiers lors du choix d'une ville
    // ==========================================================================
    const citySelect = document.getElementById('citySelect');
    const neighborhoodSelect = document.getElementById('neighborhoodSelect');

    if (citySelect && neighborhoodSelect) {
        citySelect.addEventListener('change', function () {
            const selectedCity = this.value.trim();

            // Réinitialiser
            neighborhoodSelect.innerHTML = '<option value="">Tous les quartiers</option>';

            if (!selectedCity) {
                return;
            }

            fetch('/api/neighborhoods?city=' + encodeURIComponent(selectedCity))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.neighborhoods && data.neighborhoods.length > 0) {
                        data.neighborhoods.forEach(function (n) {
                            if (n && n.trim() !== '') {
                                const opt = document.createElement('option');
                                opt.value = n;
                                opt.textContent = n;
                                neighborhoodSelect.appendChild(opt);
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Erreur chargement quartiers:', error);
                });
        });
    }

    // ==========================================================================
    // 2. Disparition automatique des alertes flash après 5 secondes
    // ==========================================================================
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function (alertEl) {
        setTimeout(function () {
            const alertInstance = bootstrap.Alert.getOrCreateInstance(alertEl);
            if (alertInstance) {
                alertInstance.close();
            }
        }, 5000);
    });

});

