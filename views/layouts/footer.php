</main>

<?php if (empty($isDashboard)): ?>
<footer class="bg-dark text-white text-center py-4 mt-5">
    <div class="container">
        <p class="mb-1 d-flex align-items-center justify-content-center gap-2">
            <i class="fa-solid fa-mortar-pestle text-success"></i>
            <strong>Phama Garde</strong> — Plateforme officielle des pharmacies de garde en Côte d'Ivoire
        </p>
        <p class="mb-0 text-muted small">&copy; <?= date('Y') ?> Phama Garde. Tous droits réservés.</p>
    </div>
</footer>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/script.js"></script>
</body>
</html>
