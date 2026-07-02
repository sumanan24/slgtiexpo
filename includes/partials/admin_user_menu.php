<?php $admin = admin_user(); if (!$admin) return; ?>
<div class="admin-user-panel mt-auto">
    <div class="admin-user-card">
        <div class="admin-user-avatar"><?= e(strtoupper(substr($admin['name'], 0, 1))) ?></div>
        <div class="admin-user-info">
            <span class="admin-user-name"><?= e($admin['name']) ?></span>
            <span class="admin-user-email"><?= e($admin['email']) ?></span>
        </div>
    </div>
    <button type="button" class="btn btn-admin-logout w-100" data-bs-toggle="modal" data-bs-target="#logoutModal">
        <i class="bi bi-box-arrow-right me-2"></i>Sign Out
    </button>
</div>
