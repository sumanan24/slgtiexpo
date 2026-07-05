<?php
/**
 * SLGTI Database Installer
 * Run once, then delete this file after successful installation.
 */
require_once __DIR__ . '/includes/init.php';

$messages = [];
$hints = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        install_database();
        $success = true;
        $messages[] = 'Database installed successfully using config/config.php connection settings.';
    } catch (Throwable $e) {
        $messages[] = 'Error: ' . $e->getMessage();
        $hint = db_connection_hint($e);
        if ($hint !== '') {
            $hints[] = $hint;
        }
    }
} else {
    try {
        $pdo = db();
        $depts = (int)$pdo->query('SELECT COUNT(*) FROM departments')->fetchColumn();
        $admins = (int)$pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn();
        $hodUsers = (int)$pdo->query('SELECT COUNT(*) FROM hod_users')->fetchColumn();
        $messages[] = "Database connected. Departments: $depts, Admins: $admins, Staff accounts: $hodUsers";
        $success = $depts > 0 && $admins > 0;
    } catch (Throwable $e) {
        $messages[] = 'Connection failed: ' . $e->getMessage();
        $hint = db_connection_hint($e);
        if ($hint !== '') {
            $hints[] = $hint;
        }
        $hints[] = 'On cPanel hosting, create the database and user first, then set db_allow_create to false in config/config.php.';
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
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="text-primary mb-4">SLGTI Database Installer</h3>
                    <?php foreach ($messages as $msg): ?>
                        <div class="alert alert-<?= $success ? 'success' : 'danger' ?>"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; ?>
                    <?php foreach ($hints as $hint): ?>
                        <div class="alert alert-warning mb-2"><?= htmlspecialchars($hint) ?></div>
                    <?php endforeach; ?>
                    <div class="bg-light border rounded p-3 mb-3 small">
                        <strong>Database config</strong><br>
                        Host: <?= htmlspecialchars($config['db_host']) ?><br>
                        Port: <?= htmlspecialchars((string)$config['db_port']) ?><br>
                        Database: <?= htmlspecialchars($config['db_name']) ?><br>
                        User: <?= htmlspecialchars($config['db_user']) ?><br>
                        Create database: <?= ($config['db_allow_create'] ?? true) ? 'Yes' : 'No (use existing cPanel database)' ?>
                    </div>
                    <?php if ($success): ?>
                        <p><strong>Admin Login:</strong> admin@slgti.lk / admin123</p>
                        <a href="<?= url('index.php') ?>" class="btn btn-primary">Go to Home</a>
                        <a href="<?= url('admin/login.php') ?>" class="btn btn-outline-primary">Admin Login</a>
                    <?php else: ?>
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
