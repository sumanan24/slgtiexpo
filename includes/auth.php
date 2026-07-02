<?php

declare(strict_types=1);

function admin_user(): ?array
{
    return $_SESSION['admin'] ?? null;
}

function require_admin(): void
{
    if (!admin_user()) {
        flash('error', 'Please login to access the admin panel.');
        redirect('admin/login.php');
    }
}

function admin_login(string $email, string $password): bool
{
    $stmt = db()->prepare('SELECT * FROM admins WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = [
            'id' => $admin['id'],
            'name' => $admin['name'],
            'email' => $admin['email'],
        ];
        return true;
    }

    return false;
}

function admin_logout(): void
{
    unset($_SESSION['admin']);
}
