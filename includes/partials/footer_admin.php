        </div>
    </div>
</div>

<!-- Logout confirmation modal -->
<div class="modal fade logout-modal" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">
                    <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <span class="admin-profile-avatar d-inline-flex" style="width:56px;height:56px;font-size:1.25rem;">
                        <?= e(strtoupper(substr(admin_user()['name'] ?? 'A', 0, 1))) ?>
                    </span>
                </div>
                <p class="mb-1 fw-semibold">Are you sure you want to sign out?</p>
                <p class="text-muted small mb-0">You will need to login again to access the admin panel.</p>
            </div>
            <div class="modal-footer justify-content-center gap-2">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                <a href="<?= url('admin/logout.php') ?>" class="btn btn-danger px-4">
                    <i class="bi bi-box-arrow-right me-1"></i>Sign Out
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (!empty($extraScripts)) echo $extraScripts; ?>
</body>
</html>
