<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Admin') ?> - SLGTI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= asset('css/slgti.css') ?>" rel="stylesheet">
</head>
<body class="admin-body">
<div class="d-flex admin-wrapper">
    <nav class="admin-sidebar text-white d-none d-lg-flex flex-column">
        <div class="admin-sidebar-brand">
            <i class="bi bi-mortarboard-fill"></i>
            <div>
                <span class="brand-title">SLGTI</span>
                <span class="brand-subtitle">Impact Report</span>
            </div>
        </div>
        <ul class="nav flex-column admin-nav">
            <li class="nav-item">
                <a class="nav-link <?= ($active ?? '') === 'dashboard' ? 'active' : '' ?>" href="<?= url('admin/dashboard.php') ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($active ?? '') === 'submissions' ? 'active' : '' ?>" href="<?= url('admin/submissions.php') ?>">
                    <i class="bi bi-file-earmark-text"></i> Submissions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($active ?? '') === 'reports' ? 'active' : '' ?>" href="<?= url('admin/reports.php') ?>">
                    <i class="bi bi-bar-chart-line"></i> Reports
                </a>
            </li>
        </ul>
        <?php require ROOT_PATH . '/includes/partials/admin_user_menu.php'; ?>
    </nav>

    <div class="flex-grow-1 admin-main">
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-admin-menu d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminMobileMenu">
                    <i class="bi bi-list"></i>
                </button>
                <div class="admin-page-title d-none d-sm-block">
                    <h1 class="h5 mb-0 text-slgti-primary"><?= e($pageTitle ?? 'Dashboard') ?></h1>
                </div>
            </div>
            <div class="admin-topbar-actions">
                <a href="<?= url('index.php') ?>" class="btn btn-topbar-link d-none d-md-inline-flex" target="_blank">
                    <i class="bi bi-box-arrow-up-right me-1"></i> View Site
                </a>
                <?php if ($admin = admin_user()): ?>
                <div class="dropdown admin-user-dropdown">
                    <button class="btn btn-admin-profile dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="admin-profile-avatar"><?= e(strtoupper(substr($admin['name'], 0, 1))) ?></span>
                        <span class="admin-profile-name d-none d-md-inline"><?= e($admin['name']) ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end admin-dropdown-menu shadow-lg border-0">
                        <li class="dropdown-header">
                            <strong><?= e($admin['name']) ?></strong>
                            <small class="d-block text-muted"><?= e($admin['email']) ?></small>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= url('admin/dashboard.php') ?>"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                        <li><a class="dropdown-item" href="<?= url('admin/submissions.php') ?>"><i class="bi bi-file-earmark-text me-2"></i>Submissions</a></li>
                        <li><a class="dropdown-item" href="<?= url('admin/reports.php') ?>"><i class="bi bi-bar-chart-line me-2"></i>Reports</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                            </button>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </header>

        <!-- Mobile sidebar -->
        <div class="offcanvas offcanvas-start admin-offcanvas" tabindex="-1" id="adminMobileMenu">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title text-white"><i class="bi bi-mortarboard-fill me-2"></i>SLGTI Admin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column">
                <ul class="nav flex-column admin-nav">
                    <li class="nav-item"><a class="nav-link" href="<?= url('admin/dashboard.php') ?>"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('admin/submissions.php') ?>"><i class="bi bi-file-earmark-text"></i> Submissions</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('admin/reports.php') ?>"><i class="bi bi-bar-chart-line"></i> Reports</a></li>
                </ul>
                <?php require ROOT_PATH . '/includes/partials/admin_user_menu.php'; ?>
            </div>
        </div>

        <div class="admin-content">
        <?php require ROOT_PATH . '/includes/partials/alerts.php'; ?>
