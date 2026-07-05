<?php

declare(strict_types=1);

function admin_user(): ?array
{
    return $_SESSION['admin'] ?? null;
}

function hod_user(): ?array
{
    return $_SESSION['hod'] ?? null;
}

function require_admin(): void
{
    if (!admin_user()) {
        flash('error', 'Please login to access the admin panel.');
        redirect('admin/login.php');
    }
}

function require_hod(): void
{
    if (!hod_user()) {
        flash('error', 'Please login to access your department portal.');
        redirect('hod/login.php');
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

function hod_login(string $email, string $password): bool
{
    $hod = HodUser::findByEmail($email);
    if (!$hod || !password_verify($password, $hod['password'])) {
        return false;
    }

    $_SESSION['hod'] = [
        'id' => (int)$hod['id'],
        'name' => $hod['name'],
        'email' => $hod['email'],
        'phone' => $hod['phone'] ?? '',
        'designation' => $hod['designation'] ?? '',
        'department_id' => (int)$hod['department_id'],
        'department_name' => $hod['department_name'],
    ];
    return true;
}

function admin_logout(): void
{
    unset($_SESSION['admin']);
}

function hod_logout(): void
{
    unset($_SESSION['hod']);
}

function hod_owns_submission(?array $submission): bool
{
    $hod = hod_user();
    if (!$hod || !$submission) {
        return false;
    }
    return (int)($submission['department_id'] ?? 0) === (int)$hod['department_id'];
}

function enforce_hod_submission_data(array $data): array
{
    $hod = hod_user();
    if (!$hod) {
        return $data;
    }
    $data['department_id'] = (int)$hod['department_id'];
    $data['hod_user_id'] = (int)$hod['id'];
    return $data;
}
