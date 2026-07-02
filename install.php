<?php
/**
 * SLGTI Database Installer
 * Run once: http://localhost/slgti/install.php
 * Delete this file after successful installation.
 */
require_once __DIR__ . '/includes/init.php';

$messages = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = file_get_contents(ROOT_PATH . '/database/slgti_impact.sql');
        $pdo = new PDO(
            sprintf('mysql:host=%s;port=%s;charset=utf8mb4', $config['db_host'], $config['db_port']),
            $config['db_user'],
            $config['db_pass'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        $pdo->exec($sql);
        $success = true;
        $messages[] = 'Database installed successfully!';
    } catch (Throwable $e) {
        $messages[] = 'Error: ' . $e->getMessage();
    }
} else {
    try {
        $pdo = db();
        $depts = (int)$pdo->query('SELECT COUNT(*) FROM departments')->fetchColumn();
        $admins = (int)$pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn();
        $messages[] = "Database connected. Departments: $depts, Admins: $admins";
        $success = $depts > 0 && $admins > 0;
    } catch (Throwable $e) {
        $messages[] = 'Connection failed: ' . $e->getMessage();
        $messages[] = 'Click Install to create database and tables.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SLGTI Database Install</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="text-primary mb-4">SLGTI Database Installer</h3>
                    <?php foreach ($messages as $msg): ?>
                        <div class="alert alert-<?= $success ? 'success' : 'warning' ?>"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; ?>
                    <?php if ($success): ?>
                        <p><strong>Admin Login:</strong> admin@slgti.lk / admin123</p>
                        <a href="<?= url('index.php') ?>" class="btn btn-primary">Go to Home</a>
                        <a href="<?= url('admin/login.php') ?>" class="btn btn-outline-primary">Admin Login</a>
                    <?php else: ?>
                        <p class="text-muted">Config: <?= htmlspecialchars($config['db_host']) ?>:<?= htmlspecialchars($config['db_port']) ?> / <?= htmlspecialchars($config['db_name']) ?></p>
                        <form method="POST">
                            <button type="submit" class="btn btn-primary w-100">Install Database</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
